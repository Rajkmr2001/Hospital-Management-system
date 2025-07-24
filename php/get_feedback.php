<?php
// get_feedback.php
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
        // Get liked_by array for each feedback
        $stmt = $conn->prepare("SELECT number FROM feedback_likes WHERE feedback_id = ?");
        $stmt->bind_param("i", $row['id']);
        $stmt->execute();
        $likes_result = $stmt->get_result();
        $liked_by = [];
        while ($like_row = $likes_result->fetch_assoc()) {
            $liked_by[] = $like_row['number'];
        }
        $stmt->close();

        $row['liked_by'] = $liked_by;
        $feedbacks[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($feedbacks);

$conn->close();
?>
