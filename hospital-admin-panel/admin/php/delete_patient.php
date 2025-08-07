<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    echo json_encode(['success' => false, 'message' => 'Authentication required']);
    exit();
}

include '../../db/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = intval($_POST['patient_id'] ?? 0);

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