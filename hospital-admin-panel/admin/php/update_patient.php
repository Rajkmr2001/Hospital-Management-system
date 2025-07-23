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
    if (empty($patient_id) || empty($name) || empty($age) || empty($gender) || empty($address) || empty($contact)) {
        echo json_encode(['success' => false, 'message' => 'All fields except medical history are required.']);
        exit;
    }
    $stmt = $conn->prepare("UPDATE patient_data SET name=?, age=?, gender=?, address=?, contact=?, medical_history=? WHERE id=?");
    $stmt->bind_param("sissssi", $name, $age, $gender, $address, $contact, $medical_history, $patient_id);
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