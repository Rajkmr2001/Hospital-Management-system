<?php
include __DIR__ . '/../../../db/config.php';

$user_ip = $_SERVER['REMOTE_ADDR'];

// Check if this IP has ever visited
$sql = "SELECT id FROM user_visits WHERE user_ip = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_ip);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // New unique IP, insert
    $stmt->close();
    $insert_sql = "INSERT INTO user_visits (user_ip) VALUES (?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("s", $user_ip);
    $insert_stmt->execute();
    $insert_stmt->close();
} else {
    $stmt->close();
}

$conn->close();
?> 