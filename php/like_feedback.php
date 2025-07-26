<?php
include '../db/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $number = $_POST['number'] ?? '';
    $action = $_POST['action'] ?? 'like'; // 'like' or 'dislike'
    
    if ($id && $number) {
        // Check if user has already interacted with this feedback
        $check = $conn->prepare("SELECT * FROM feedback_likes WHERE feedback_id = ? AND number = ?");
        $check->bind_param("is", $id, $number);
        $check->execute();
        $result = $check->get_result();
        
        if ($result->num_rows == 0) {
            // First time interaction - add like or dislike
            if ($action === 'like') {
                $conn->query("UPDATE feedback SET likes = likes + 1 WHERE id = $id");
            } else {
                $conn->query("UPDATE feedback SET dislikes = dislikes + 1 WHERE id = $id");
            }
            
            $insert = $conn->prepare("INSERT INTO feedback_likes (feedback_id, number, dislike_type) VALUES (?, ?, ?)");
            $insert->bind_param("iss", $id, $number, $action);
            $insert->execute();
            
            echo json_encode(['success' => true, 'action' => $action]);
        } else {
            // User has already interacted - handle toggle
            $existing = $result->fetch_assoc();
            $current_action = $existing['dislike_type'];
            
            if ($current_action === $action) {
                // Remove the interaction (toggle off)
                if ($action === 'like') {
                    $conn->query("UPDATE feedback SET likes = likes - 1 WHERE id = $id");
                } else {
                    $conn->query("UPDATE feedback SET dislikes = dislikes - 1 WHERE id = $id");
                }
                
                $delete = $conn->prepare("DELETE FROM feedback_likes WHERE feedback_id = ? AND number = ?");
                $delete->bind_param("is", $id, $number);
                $delete->execute();
                
                echo json_encode(['success' => true, 'action' => 'removed']);
            } else {
                // Change from like to dislike or vice versa
                if ($current_action === 'like') {
                    $conn->query("UPDATE feedback SET likes = likes - 1, dislikes = dislikes + 1 WHERE id = $id");
                } else {
                    $conn->query("UPDATE feedback SET dislikes = dislikes - 1, likes = likes + 1 WHERE id = $id");
                }
                
                $update = $conn->prepare("UPDATE feedback_likes SET dislike_type = ? WHERE feedback_id = ? AND number = ?");
                $update->bind_param("sis", $action, $id, $number);
                $update->execute();
                
                echo json_encode(['success' => true, 'action' => $action]);
            }
        }
        $check->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing fields']);
    }
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
