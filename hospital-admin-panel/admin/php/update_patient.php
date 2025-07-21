<?php
include '../../db/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $medical_history = $_POST['medical_history'];

    // Validate input
    if (empty($patient_id) || empty($name) || empty($age) || empty($gender) || empty($address) || empty($contact)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE patients SET name=?, age=?, gender=?, address=?, contact=?, medical_history=? WHERE id=?");
    $stmt->bind_param("sissssi", $name, $age, $gender, $address, $contact, $medical_history, $patient_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Patient updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating patient: ' . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>