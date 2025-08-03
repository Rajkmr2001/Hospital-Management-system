<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_management";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Disable error reporting for production
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    // Validate mobile number
    if (!preg_match("/^\d{10}$/", $mobile)) {
        echo json_encode(['success' => false, 'message' => 'Invalid mobile number format']);
        exit();
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM patient_register WHERE mobile_no = ?");
    $stmt->bind_param("s", $mobile);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Check password using password_verify for hashed passwords
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['patient_id'] = $user['id'] ?? $user['mobile_no']; // Use mobile_no as fallback if id doesn't exist
            $_SESSION['patient_mobile'] = $user['mobile_no'];
            $_SESSION['patient_name'] = $user['name'];
            $_SESSION['patient_logged_in'] = true;
            
            echo json_encode(['success' => true, 'message' => 'Login successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Mobile number not registered']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?> 