<?php
// submit_message.php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'hospital_management';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Get POST data and sanitize
$name = $conn->real_escape_string(trim($_POST['name'] ?? ''));
$email = $conn->real_escape_string(trim($_POST['email'] ?? ''));
$subject = $conn->real_escape_string(trim($_POST['subject'] ?? ''));
$message = $conn->real_escape_string(trim($_POST['message'] ?? ''));

if (!$name || !$email || !$subject || !$message) {
    http_response_code(400);
    echo json_encode(['error' => 'All fields are required']);
    $conn->close();
    exit;
}

// Insert message into database
$sql = "INSERT INTO messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => 'Message received']);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save message: ' . $conn->error]);
}

$conn->close();
?>
