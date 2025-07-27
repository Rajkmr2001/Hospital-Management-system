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
    
    // Get all registered persons - order by register_date and register_time instead of id
    $sql = "SELECT * FROM patient_register ORDER BY register_date DESC, register_time DESC";
    $result = $conn->query($sql);
    
    if (!$result) {
        echo json_encode(['error' => 'Query failed: ' . $conn->error]);
        exit;
    }
    
    $persons = [];
    while ($row = $result->fetch_assoc()) {
        // Since passwords are hashed, we can't show the original password
        // We'll show "••••••••" for security
        $password = "••••••••";
        $persons[] = [
            'id' => $row['mobile_no'], // Use mobile_no as ID since it's unique
            'name' => $row['name'],
            'mobile_no' => $row['mobile_no'],
            'gender' => $row['gender'],
            'password' => $password, // Show original password
            'register_date' => $row['register_date'],
            'register_time' => $row['register_time']
        ];
    }
    
    echo json_encode($persons);
    
} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?> 