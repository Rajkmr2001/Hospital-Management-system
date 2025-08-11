<?php
session_start();

// Use shared DB config (auto points to InfinityFree in production)
include __DIR__ . '/db/config.php';

header('Content-Type: application/json');

// Check if patient is logged in
if (!isset($_SESSION['patient_logged_in']) || $_SESSION['patient_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

// Enable error reporting for debugging (only if not already output)
if (!headers_sent()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$patient_mobile = $_SESSION['patient_mobile'];

try {
    // Get patient registration info
    $stmt = $conn->prepare("SELECT * FROM patient_register WHERE mobile_no = ?");
    $stmt->bind_param("s", $patient_mobile);
    $stmt->execute();
    $patient_register = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    // Check if patient_register exists
    if (!$patient_register) {
        echo json_encode([
            'success' => false,
            'message' => 'Patient registration not found'
        ]);
        exit();
    }

    // Get patient data (additional info) - try to match by contact or name
    $patient_data = null;
    
    // First try to match by contact number
    $stmt = $conn->prepare("SELECT * FROM patient_data WHERE contact = ?");
    $stmt->bind_param("s", $patient_mobile);
    $stmt->execute();
    $patient_data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    
    // If not found by contact, try to match by name
    if (!$patient_data && $patient_register['name']) {
        $stmt = $conn->prepare("SELECT * FROM patient_data WHERE name = ?");
        $stmt->bind_param("s", $patient_register['name']);
        $stmt->execute();
        $patient_data = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }

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
    $messages = [];
    if ($patient_register && $patient_register['name']) {
        $stmt = $conn->prepare("SELECT * FROM messages WHERE name = ? ORDER BY timestamp DESC");
        $stmt->bind_param("s", $patient_register['name']);
        $stmt->execute();
        $messages_result = $stmt->get_result();
        while ($row = $messages_result->fetch_assoc()) {
            $messages[] = $row;
        }
        $stmt->close();
    }

    // Get last visit (support ip_address or user_ip, and visit_datetime fallback)
    $ipCol = 'user_ip';
    if ($res = $conn->query("SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'user_visits' AND column_name = 'user_ip' LIMIT 1")) {
        if ($res->num_rows === 0) { $ipCol = 'ip_address'; }
        $res->close();
    }
    $tsExpr = "CONCAT(visit_date, ' ', visit_time)";
    if ($res = $conn->query("SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'user_visits' AND column_name = 'visit_datetime' LIMIT 1")) {
        if ($res->num_rows > 0) { $tsExpr = 'visit_datetime'; }
        $res->close();
    }
    $stmt = $conn->prepare("SELECT $tsExpr as visit_datetime FROM user_visits WHERE `$ipCol` = ? ORDER BY $tsExpr DESC LIMIT 1");
    $stmt->bind_param("s", $_SERVER['REMOTE_ADDR']);
    $stmt->execute();
    $visit_result = $stmt->get_result();
    $last_visit = $visit_result->fetch_assoc();
    $stmt->close();

    // Combine patient information
    $patient_info = [
        'name' => $patient_register['name'] ?? 'N/A',
        'age' => $patient_data['age'] ?? 'N/A',
        'gender' => $patient_register['gender'] ?? 'N/A',
        'contact' => $patient_mobile,
        'address' => $patient_data['address'] ?? 'N/A',
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