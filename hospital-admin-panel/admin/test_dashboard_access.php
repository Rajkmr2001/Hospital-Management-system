<?php
// Simple test file to check if PHP is working in this directory
echo "PHP is working in the admin directory!<br>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Dashboard auth file exists: " . (file_exists(__DIR__ . '/dashboard_auth.php') ? 'YES' : 'NO') . "<br>";
echo "Auth check file exists: " . (file_exists(__DIR__ . '/php/auth_check.php') ? 'YES' : 'NO') . "<br>";
echo "Dashboard HTML file exists: " . (file_exists(__DIR__ . '/dashboard.html') ? 'YES' : 'NO') . "<br>";

// Test if we can include auth_check.php
try {
    include __DIR__ . '/php/auth_check.php';
    echo "Auth check include: SUCCESS<br>";
} catch (Exception $e) {
    echo "Auth check include: FAILED - " . $e->getMessage() . "<br>";
}

// Test session
session_start();
echo "Session admin_id: " . (isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 'NOT SET') . "<br>";
echo "Session admin_username: " . (isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'NOT SET') . "<br>";
?> 