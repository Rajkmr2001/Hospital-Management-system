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
    $feedback_id = intval($_POST['feedback_id'] ?? 0);
    $user_ip = $_POST['user_ip'] ?? '';
    $action = $_POST['action'] ?? 'like'; // 'like' or 'dislike'
    
    if ($feedback_id && $user_ip && $action) {
        // Check if user already interacted with this feedback
        $stmt = $conn->prepare("SELECT id, dislike_type FROM feedback_likes WHERE feedback_id = ? AND user_ip = ?");
        $stmt->bind_param("is", $feedback_id, $user_ip);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $existing = $result->fetch_assoc();
            if ($existing['dislike_type'] === $action) {
                // User is clicking the same action, remove it
                $stmt = $conn->prepare("DELETE FROM feedback_likes WHERE feedback_id = ? AND user_ip = ?");
                $stmt->bind_param("is", $feedback_id, $user_ip);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'action' => 'removed']);
                } else {
                    echo json_encode(['success' => false, 'message' => $stmt->error]);
                }
            } else {
                // User is changing from like to dislike or vice versa, update it
                $stmt = $conn->prepare("UPDATE feedback_likes SET dislike_type = ?, liked_at = NOW() WHERE feedback_id = ? AND user_ip = ?");
                $stmt->bind_param("sis", $action, $feedback_id, $user_ip);
                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'action' => 'changed']);
                } else {
                    echo json_encode(['success' => false, 'message' => $stmt->error]);
                }
            }
        } else {
            // User hasn't interacted, add the interaction
            $stmt = $conn->prepare("INSERT INTO feedback_likes (feedback_id, user_ip, dislike_type, liked_at) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("iss", $feedback_id, $user_ip, $action);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'action' => 'added']);
            } else {
                echo json_encode(['success' => false, 'message' => $stmt->error]);
            }
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
