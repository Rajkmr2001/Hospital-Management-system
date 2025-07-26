<?php
include __DIR__ . '/../../../db/config.php';
header('Content-Type: application/json');

try {
    // Get total count of registered persons
    $sql = "SELECT COUNT(*) as total FROM patient_register";
    $result = $conn->query($sql);
    
    if ($result) {
        $row = $result->fetch_assoc();
        echo json_encode(['total' => (int)$row['total']]);
    } else {
        echo json_encode(['total' => 0]);
    }
    
} catch (Exception $e) {
    echo json_encode(['total' => 0, 'error' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?> 