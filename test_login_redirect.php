<?php
// Test script to verify login redirect
session_start();

echo "<h2>Login Redirect Test</h2>";

// Check if user is logged in
if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username'])) {
    echo "<p style='color: green;'>✅ User is logged in!</p>";
    echo "<ul>";
    echo "<li><strong>Admin ID:</strong> " . $_SESSION['admin_id'] . "</li>";
    echo "<li><strong>Admin Username:</strong> " . $_SESSION['admin_username'] . "</li>";
    echo "</ul>";
    
    echo "<p><strong>Dashboard Links:</strong></p>";
    echo "<ul>";
    echo "<li><a href='hospital-admin-panel/admin/dashboard.php' target='_blank'>Dashboard (PHP)</a></li>";
    echo "<li><a href='hospital-admin-panel/admin/dashboard.html' target='_blank'>Dashboard (HTML - should fail)</a></li>";
    echo "</ul>";
    
    echo "<p><strong>Test Logout:</strong></p>";
    echo "<p><a href='hospital-admin-panel/admin/php/logout.php'>Logout</a></p>";
    
} else {
    echo "<p style='color: red;'>❌ User is not logged in!</p>";
    echo "<p>Please login first: <a href='hospital-admin-panel/admin/login.html' target='_blank'>Go to Login</a></p>";
}

echo "<hr>";
echo "<h3>Session Information</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 