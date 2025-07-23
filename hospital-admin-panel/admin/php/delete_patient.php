<?php
// delete_patient.php

include '../../db/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM patient_data WHERE id = ?");
    $stmt->bind_param("i", $patient_id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Patient record deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete patient record."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>