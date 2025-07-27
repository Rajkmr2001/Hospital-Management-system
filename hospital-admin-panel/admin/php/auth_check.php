<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login.html");
    exit();
}

// Optional: Check if admin is still active in database
include '../../db/config.php';

$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT is_active FROM admins WHERE id = ? AND is_active = 1");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Admin account is deactivated or doesn't exist
    session_destroy();
    header("Location: ../login.html");
    exit();
}

$stmt->close();
$conn->close();

// Update last login time
include '../../db/config.php';
$update_stmt = $conn->prepare("UPDATE admins SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
$update_stmt->bind_param("i", $admin_id);
$update_stmt->execute();
$update_stmt->close();
$conn->close();
?> 