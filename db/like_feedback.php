<?php
include 'db/config.php';
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $number = $_POST['number'] ?? '';
    if ($id && $number) {
        // Prevent multiple likes from the same number
        $check = $conn->prepare("SELECT * FROM feedback_likes WHERE feedback_id = ? AND number = ?");
        $check->bind_param("is", $id, $number);
        $check->execute();
        $result = $check->get_result();
        if ($result->num_rows == 0) {
            // Add like
            $conn->query("UPDATE feedback SET likes = likes + 1 WHERE id = $id");
            $insert = $conn->prepare("INSERT INTO feedback_likes (feedback_id, number) VALUES (?, ?)");
            $insert->bind_param("is", $id, $number);
            $insert->execute();
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Already liked']);
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
