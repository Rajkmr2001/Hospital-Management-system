<?php
// Simplified version for testing
echo "Starting dashboard_auth_simple.php<br>";

// Include authentication check
try {
    include __DIR__ . '/php/auth_check.php';
    echo "Auth check passed<br>";
} catch (Exception $e) {
    echo "Auth check failed: " . $e->getMessage() . "<br>";
    exit();
}

// If we reach here, user is authenticated
echo "User is authenticated!<br>";
echo "Admin username: " . (isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'NOT SET') . "<br>";

// Simple dashboard content
echo '<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Simple Test</title>
</head>
<body>
    <h1>Dashboard Test Page</h1>
    <p>Welcome back, ' . htmlspecialchars($_SESSION['admin_username']) . '!</p>
    <p>This is a simplified test version of the dashboard.</p>
    <a href="php/logout.php">Logout</a>
    <br><br>
    <a href="dashboard_auth.php">Try Full Dashboard</a>
</body>
</html>';
?> 