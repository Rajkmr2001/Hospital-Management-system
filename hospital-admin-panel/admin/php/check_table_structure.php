<?php
include __DIR__ . '/../../../db/config.php';
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Check if table exists
    $table_check = $conn->query("SHOW TABLES LIKE 'patient_register'");
    if ($table_check->num_rows === 0) {
        echo json_encode(['error' => 'Table patient_register does not exist']);
        exit;
    }
    
    // Get table structure
    $structure_result = $conn->query("DESCRIBE patient_register");
    $columns = [];
    while ($row = $structure_result->fetch_assoc()) {
        $columns[] = $row;
    }
    
    // Get sample data (first 3 rows)
    $sample_result = $conn->query("SELECT * FROM patient_register LIMIT 3");
    $sample_data = [];
    while ($row = $sample_result->fetch_assoc()) {
        $sample_data[] = $row;
    }
    
    echo json_encode([
        'table_exists' => true,
        'columns' => $columns,
        'sample_data' => $sample_data
    ]);
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?> 