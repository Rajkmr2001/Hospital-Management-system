<?php
include '../db/config.php'; // adjust path as needed
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $number = $_POST['number'] ?? '';
    $comment = $_POST['comment'] ?? '';
    $likes = 0;

    if ($name && $number && $comment) {
        $stmt = $conn->prepare("INSERT INTO feedback (name, number, comment, likes) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $number, $comment, $likes);
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
