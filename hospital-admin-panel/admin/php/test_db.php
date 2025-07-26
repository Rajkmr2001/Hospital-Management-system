<?php
include __DIR__ . '/../../../db/config.php';
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Test database connection
    if ($conn->connect_error) {
        echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
        exit;
    }
    
    echo json_encode(['message' => 'Database connection successful']);
    
    // Check if table exists
    $table_check = $conn->query("SHOW TABLES LIKE 'patient_register'");
    if ($table_check->num_rows === 0) {
        echo json_encode(['error' => 'Table patient_register does not exist. Please run the SQL script to create it.']);
        exit;
    }
    
    // Count records
    $count_result = $conn->query("SELECT COUNT(*) as count FROM patient_register");
    $count = $count_result->fetch_assoc()['count'];
    
    echo json_encode([
        'message' => 'Database connection successful',
        'table_exists' => true,
        'record_count' => $count
    ]);
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?> 