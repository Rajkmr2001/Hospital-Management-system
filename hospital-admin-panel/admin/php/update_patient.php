<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    echo json_encode(['success' => false, 'message' => 'Authentication required']);
    exit();
}

include '../../db/config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = intval($_POST['patient_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $gender = trim($_POST['gender'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $medical_history = trim($_POST['medical_history'] ?? '');
    if (empty($patient_id) || empty($name) || empty($age) || empty($gender) || empty($contact) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'Patient ID, name, age, gender, contact, and address are required fields.']);
        exit;
    }
    $stmt = $conn->prepare("UPDATE patient_data SET contact=?, name=?, age=?, gender=?, address=?, medical_history=? WHERE id=?");
    $stmt->bind_param("ssisssi", $contact, $name, $age, $gender, $address, $medical_history, $patient_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Patient updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating patient: ' . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>