<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    echo json_encode(['success' => false, 'message' => 'Authentication required']);
    exit();
}

include '../../db/config.php';
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $age = intval($_POST['age'] ?? 0);
    $gender = trim($_POST['gender'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $medical_history = trim($_POST['medical_history'] ?? '');

    if (empty($name) || empty($age) || empty($gender) || empty($contact) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'Name, age, gender, contact, and address are required fields.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO patient_data (contact, name, age, gender, address, medical_history) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $contact, $name, $age, $gender, $address, $medical_history);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'New patient added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>