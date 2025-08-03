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

header('Content-Type: application/json');

// Check if patient is logged in
if (!isset($_SESSION['patient_logged_in']) || $_SESSION['patient_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

$patient_mobile = $_SESSION['patient_mobile'];

try {
    // Get patient registration info
    $stmt = $conn->prepare("SELECT * FROM patient_register WHERE mobile_no = ?");
    $stmt->bind_param("s", $patient_mobile);
    $stmt->execute();
    $patient_register = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Get patient data (additional info)
    $stmt = $conn->prepare("SELECT * FROM patient_data WHERE contact = ?");
    $stmt->bind_param("s", $patient_mobile);
    $stmt->execute();
    $patient_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Get patient feedback
    $stmt = $conn->prepare("SELECT * FROM feedback WHERE number = ? ORDER BY timestamp DESC");
    $stmt->bind_param("s", $patient_mobile);
    $stmt->execute();
    $feedback_result = $stmt->get_result();
    $feedback = [];
    while ($row = $feedback_result->fetch_assoc()) {
        $feedback[] = $row;
    }
    $stmt->close();

    // Get patient messages
    $stmt = $conn->prepare("SELECT * FROM messages WHERE name = ? ORDER BY timestamp DESC");
    $stmt->bind_param("s", $patient_register['name']);
    $stmt->execute();
    $messages_result = $stmt->get_result();
    $messages = [];
    while ($row = $messages_result->fetch_assoc()) {
        $messages[] = $row;
    }
    $stmt->close();

    // Get last visit
    $stmt = $conn->prepare("SELECT CONCAT(visit_date, ' ', visit_time) as visit_datetime FROM user_visits WHERE user_ip = ? ORDER BY visit_date DESC, visit_time DESC LIMIT 1");
    $stmt->bind_param("s", $_SERVER['REMOTE_ADDR']);
    $stmt->execute();
    $visit_result = $stmt->get_result();
    $last_visit = $visit_result->fetch_assoc();
    $stmt->close();

    // Combine patient information
    $patient_info = [
        'name' => $patient_register['name'] ?? $patient_data['name'] ?? 'N/A',
        'age' => $patient_data['age'] ?? 'N/A',
        'gender' => $patient_register['gender'] ?? $patient_data['gender'] ?? 'N/A',
        'contact' => $patient_mobile,
        'address' => $patient_data['address'] ?? 'NULL',
        'medical_history' => $patient_data['medical_history'] ?? 'NULL',
        'register_date' => $patient_register['register_date'] ?? 'N/A',
        'total_feedback' => count($feedback),
        'total_messages' => count($messages),
        'last_visit' => $last_visit['visit_datetime'] ?? 'N/A'
    ];

    // Check for profile picture
    $profile_picture = null;
    $picture_path = "profile_pictures/" . $patient_mobile . ".jpg";
    if (file_exists($picture_path)) {
        $profile_picture = $picture_path;
    }

    echo json_encode([
        'success' => true,
        'patient_info' => $patient_info,
        'feedback' => $feedback,
        'messages' => $messages,
        'profile_picture' => $profile_picture
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

$conn->close();
?> 