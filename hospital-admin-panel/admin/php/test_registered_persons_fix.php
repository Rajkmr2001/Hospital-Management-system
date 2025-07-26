<?php
include __DIR__ . '/../../../db/config.php';
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Test 1: Check if table exists
    $table_check = $conn->query("SHOW TABLES LIKE 'patient_register'");
    if ($table_check->num_rows === 0) {
        echo json_encode(['error' => 'Table patient_register does not exist']);
        exit;
    }
    
    // Test 2: Get table structure
    $structure_result = $conn->query("DESCRIBE patient_register");
    $columns = [];
    while ($row = $structure_result->fetch_assoc()) {
        $columns[] = $row;
    }
    
    // Test 3: Try the modified query (without ORDER BY id)
    $sql = "SELECT * FROM patient_register ORDER BY register_date DESC, register_time DESC";
    $result = $conn->query($sql);
    
    if (!$result) {
        echo json_encode(['error' => 'Query failed: ' . $conn->error]);
        exit;
    }
    
    $persons = [];
    while ($row = $result->fetch_assoc()) {
        $persons[] = [
            'id' => $row['mobile_no'], // Use mobile_no as ID
            'name' => $row['name'],
            'mobile_no' => $row['mobile_no'],
            'gender' => $row['gender'],
            'register_date' => $row['register_date'],
            'register_time' => $row['register_time']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'table_exists' => true,
        'columns' => $columns,
        'persons_count' => count($persons),
        'sample_persons' => array_slice($persons, 0, 3) // First 3 records
    ]);
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?> 