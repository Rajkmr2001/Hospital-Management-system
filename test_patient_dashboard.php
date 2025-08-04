<?php
// Test file to debug patient dashboard data loading
session_start();
header('Content-Type: application/json');

echo "=== PATIENT DASHBOARD DEBUG ===\n\n";

// Check session
echo "Session data:\n";
var_dump($_SESSION);
echo "\n";

// Check if patient is logged in
if (isset($_SESSION['patient_logged_in']) && $_SESSION['patient_logged_in'] === true) {
    echo "✅ Patient is logged in\n";
    echo "Patient mobile: " . ($_SESSION['patient_mobile'] ?? 'NOT SET') . "\n";
    echo "Patient name: " . ($_SESSION['patient_name'] ?? 'NOT SET') . "\n";
} else {
    echo "❌ Patient is NOT logged in\n";
    echo "patient_logged_in: " . (isset($_SESSION['patient_logged_in']) ? $_SESSION['patient_logged_in'] : 'NOT SET') . "\n";
}

// Test database connection
echo "\n=== DATABASE CONNECTION TEST ===\n";
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'hospital_management';
$port = 3306;

$conn = new mysqli($host, $user, $password, $dbname, $port);
if ($conn->connect_error) {
    echo "❌ Database connection failed: " . $conn->connect_error . "\n";
} else {
    echo "✅ Database connection successful\n";
    
    // Test patient_register table
    if (isset($_SESSION['patient_mobile'])) {
        $patient_mobile = $_SESSION['patient_mobile'];
        $stmt = $conn->prepare("SELECT * FROM patient_register WHERE mobile_no = ?");
        $stmt->bind_param("s", $patient_mobile);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $patient = $result->fetch_assoc();
            echo "✅ Patient found in patient_register:\n";
            echo "  - Name: " . $patient['name'] . "\n";
            echo "  - Mobile: " . $patient['mobile_no'] . "\n";
            echo "  - Gender: " . $patient['gender'] . "\n";
            echo "  - Register Date: " . $patient['register_date'] . "\n";
        } else {
            echo "❌ Patient NOT found in patient_register for mobile: " . $patient_mobile . "\n";
        }
        $stmt->close();
        
        // Test patient_data table
        $stmt = $conn->prepare("SELECT * FROM patient_data WHERE contact = ?");
        $stmt->bind_param("s", $patient_mobile);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $patient_data = $result->fetch_assoc();
            echo "✅ Patient found in patient_data:\n";
            echo "  - Name: " . $patient_data['name'] . "\n";
            echo "  - Age: " . $patient_data['age'] . "\n";
            echo "  - Address: " . $patient_data['address'] . "\n";
        } else {
            echo "❌ Patient NOT found in patient_data for contact: " . $patient_mobile . "\n";
        }
        $stmt->close();
        
        // Test feedback table
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM feedback WHERE number = ?");
        $stmt->bind_param("s", $patient_mobile);
        $stmt->execute();
        $result = $stmt->get_result();
        $feedback_count = $result->fetch_assoc()['count'];
        echo "📊 Feedback count: " . $feedback_count . "\n";
        $stmt->close();
        
        // Test messages table
        if (isset($patient['name'])) {
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM messages WHERE name = ?");
            $stmt->bind_param("s", $patient['name']);
            $stmt->execute();
            $result = $stmt->get_result();
            $messages_count = $result->fetch_assoc()['count'];
            echo "📊 Messages count: " . $messages_count . "\n";
            $stmt->close();
        }
    }
    
    $conn->close();
}

echo "\n=== END DEBUG ===\n";
?> 