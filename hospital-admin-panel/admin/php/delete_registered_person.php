<?php
include __DIR__ . '/../../../db/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ID is required']);
        exit;
    }
    
    try {
            // Delete the registered person using mobile_no as identifier
    $sql = "DELETE FROM patient_register WHERE mobile_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'Registered person deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No record found with this ID']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete record']);
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?> 