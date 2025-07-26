<?php
// get_feedback_with_timestamps.php
include '../db/config.php';
session_start();

/* Temporarily bypass login check for testing */
#if (!isset($_SESSION['admin_id'])) {
#    http_response_code(401);
#    echo json_encode(['error' => 'Unauthorized']);
#    exit();
#}

$sql = "SELECT * FROM feedback ORDER BY id DESC";
$result = $conn->query($sql);

$feedbacks = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Get liked_by, disliked_by arrays and timestamps for each feedback
        $stmt = $conn->prepare("SELECT number, dislike_type, created_at FROM feedback_likes WHERE feedback_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $row['id']);
        $stmt->execute();
        $likes_result = $stmt->get_result();
        $liked_by = [];
        $disliked_by = [];
        $latest_interaction = null;
        
        while ($like_row = $likes_result->fetch_assoc()) {
            if ($like_row['dislike_type'] === 'like') {
                $liked_by[] = $like_row['number'];
            } else {
                $disliked_by[] = $like_row['number'];
            }
            
            // Track the latest interaction timestamp
            if (!$latest_interaction || $like_row['created_at'] > $latest_interaction) {
                $latest_interaction = $like_row['created_at'];
            }
        }
        $stmt->close();

        $row['liked_by'] = $liked_by;
        $row['disliked_by'] = $disliked_by;
        $row['latest_interaction'] = $latest_interaction;
        $row['likes_count'] = count($liked_by);
        $row['dislikes_count'] = count($disliked_by);
        $feedbacks[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($feedbacks);

$conn->close();
?> 