<?php
include __DIR__ . '/../../../db/config.php';

$user_ip = $_SERVER['REMOTE_ADDR'];

// Check if this IP has already visited today
$today = date('Y-m-d');
$check_sql = "SELECT id FROM user_visits WHERE user_ip = ? AND DATE(visit_time) = ? LIMIT 1";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ss", $user_ip, $today);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows === 0) {
    // First visit today for this IP - insert new record
    $check_stmt->close();
    $insert_sql = "INSERT INTO user_visits (user_ip, visit_time) VALUES (?, NOW())";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("s", $user_ip);
    $insert_stmt->execute();
    $insert_stmt->close();
} else {
    // IP has already visited today - update visit_time to current time
    $check_stmt->close();
    $update_sql = "UPDATE user_visits SET visit_time = NOW() WHERE user_ip = ? AND DATE(visit_time) = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ss", $user_ip, $today);
    $update_stmt->execute();
    $update_stmt->close();
}

$conn->close();
?> 