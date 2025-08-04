<?php
include '../../db/config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $address = $_POST['address'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $medical_history = $_POST['medical_history'] ?? '';
    if (empty($patient_id) || empty($name) || empty($age) || empty($gender) || empty($contact) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'Patient ID, name, age, gender, contact, and address are required fields.']);
        exit;
    }
    $stmt = $conn->prepare("UPDATE patient_data SET contact=?, name=?, age=?, gender=?, address=? WHERE id=?");
    $stmt->bind_param("ssissi", $contact, $name, $age, $gender, $address, $patient_id);
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