<?php
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

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $number = $_POST['number'] ?? '';
    $comment = $_POST['comment'] ?? '';

if ($name && $number && $comment) {
    $stmt = $conn->prepare("INSERT INTO feedback (name, number, feedback, timestamp) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $name, $number, $comment);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
    $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing fields']);
    }
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
