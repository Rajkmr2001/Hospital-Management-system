<?php
session_start();
include 'db/config.php';

// Disable error reporting for production
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

// Check if patient is logged in
if (!isset($_SESSION['patient_logged_in']) || $_SESSION['patient_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

$patient_mobile = $_SESSION['patient_mobile'];

// Get form data
$name = trim($_POST['name'] ?? '');
$age = trim($_POST['age'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$address = trim($_POST['address'] ?? '');
$medical_history = trim($_POST['medical_history'] ?? '');

// Validate required fields
if (empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Name is required']);
    exit();
}

if (!empty($age) && (!is_numeric($age) || $age < 1 || $age > 120)) {
    echo json_encode(['success' => false, 'message' => 'Age must be between 1 and 120']);
    exit();
}

if (!in_array($gender, ['Male', 'Female', 'Other'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid gender selection']);
    exit();
}

try {
    // Start transaction
    $conn->begin_transaction();
    
    // Update patient_register table
    $stmt = $conn->prepare("UPDATE patient_register SET name = ?, gender = ? WHERE mobile_no = ?");
    $stmt->bind_param("sss", $name, $gender, $patient_mobile);
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to update patient registration info: ' . $stmt->error);
    }
    $stmt->close();
    
    // Check if patient_data record exists
    $stmt = $conn->prepare("SELECT id FROM patient_data WHERE contact = ?");
    $stmt->bind_param("s", $patient_mobile);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    
    if ($result->num_rows > 0) {
        // Update existing patient_data record
        $stmt = $conn->prepare("UPDATE patient_data SET name = ?, age = ?, gender = ?, address = ?, medical_history = ? WHERE contact = ?");
        $stmt->bind_param("sissss", $name, $age, $gender, $address, $medical_history, $patient_mobile);
    } else {
        // Insert new patient_data record
        $stmt = $conn->prepare("INSERT INTO patient_data (contact, name, age, gender, address, medical_history, submission_time, submission_date) VALUES (?, ?, ?, ?, ?, ?, NOW(), CURDATE())");
        $stmt->bind_param("ssisss", $patient_mobile, $name, $age, $gender, $address, $medical_history);
    }
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to update patient data: ' . $stmt->error);
    }
    $stmt->close();
    
    // Commit transaction
    $conn->commit();
    
    // Update session name if it changed
    if ($name !== $_SESSION['patient_name']) {
        $_SESSION['patient_name'] = $name;
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Information updated successfully'
    ]);
    
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

$conn->close();
?> 