<?php
// Include database configuration
include '../../db/config.php';
header('Content-Type: application/json');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get patient details from the form
    $name = $_POST['name'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $address = $_POST['address'] ?? '';
    $medical_history = $_POST['medical_history'] ?? '';

    // Validate required fields
    if (empty($name) || empty($age) || empty($gender) || empty($contact) || empty($address)) {
        echo json_encode(['success' => false, 'message' => 'All fields except medical history are required.']);
        exit;
    }

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO patient_data (name, age, gender, contact, address, medical_history) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $name, $age, $gender, $contact, $address, $medical_history);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'New patient added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>