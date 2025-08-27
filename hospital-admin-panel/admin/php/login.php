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

// Set header to return JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mobile_number = $_POST['mobile_number'];
    $password = $_POST['password'];

    // Validate input
    if (empty($mobile_number) || empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => 'Please enter both mobile number and password.'
        ]);
        exit();
    }

    // Check if admins table exists
    $table_check = $conn->query("SHOW TABLES LIKE 'admins'");
    if ($table_check->num_rows == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Admin system not set up. Please run the setup script first.'
        ]);
        exit();
    }

    // Check if mobile_number column exists
    $column_check = $conn->query("SHOW COLUMNS FROM admins LIKE 'mobile_number'");
    if ($column_check->num_rows == 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Mobile number column not found. Please run the migration script.'
        ]);
        exit();
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM admins WHERE mobile_number = ? LIMIT 1");
    
    if ($stmt === false) {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ]);
        exit();
    }

    $stmt->bind_param("s", $mobile_number);
    
    if (!$stmt->execute()) {
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $stmt->error
        ]);
        $stmt->close();
        exit();
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $admin['password'])) {
            // Password is correct, set session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            echo json_encode([
                'success' => true,
                'message' => 'Login successful!',
                'redirect' => 'dashboard_auth.php'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid credentials. Please try again.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid credentials. Please try again.'
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}

$conn->close();
?>