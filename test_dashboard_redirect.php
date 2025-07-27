<?php
// Test script to verify dashboard redirect fix
session_start();

echo "<h2>Dashboard Redirect Fix Test</h2>";

// Test 1: Check current session
echo "<h3>1. Current Session Status</h3>";
if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username'])) {
    echo "<p style='color: green;'>✅ User is logged in</p>";
    echo "<ul>";
    echo "<li>Admin ID: " . $_SESSION['admin_id'] . "</li>";
    echo "<li>Admin Username: " . $_SESSION['admin_username'] . "</li>";
    echo "</ul>";
} else {
    echo "<p style='color: orange;'>⚠️ User is not logged in</p>";
}

// Test 2: Check login.php redirect path
echo "<h3>2. Login Redirect Path Check</h3>";
$login_file = 'hospital-admin-panel/admin/php/login.php';
if (file_exists($login_file)) {
    $content = file_get_contents($login_file);
    if (strpos($content, "'redirect' => '../dashboard.html'") !== false) {
        echo "<p style='color: green;'>✅ Login redirects to dashboard.html</p>";
    } else {
        echo "<p style='color: red;'>❌ Login redirect path is incorrect</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Login.php file not found</p>";
}

// Test 3: Check dashboard files
echo "<h3>3. Dashboard Files Check</h3>";
$dashboard_html = 'hospital-admin-panel/admin/dashboard.html';

if (file_exists($dashboard_html)) {
    echo "<p style='color: green;'>✅ dashboard.html exists</p>";
} else {
    echo "<p style='color: red;'>❌ dashboard.html not found</p>";
}

// Test 4: Test links
echo "<h3>4. Test Links</h3>";
echo "<ul>";
echo "<li><a href='hospital-admin-panel/admin/login.html' target='_blank'>Login Page</a></li>";
echo "<li><a href='hospital-admin-panel/admin/dashboard.html' target='_blank'>Dashboard (Direct HTML)</a></li>";
echo "</ul>";

// Test 5: Instructions
echo "<h3>5. How to Test</h3>";
echo "<ol>";
echo "<li>Go to <a href='hospital-admin-panel/admin/login.html' target='_blank'>Login Page</a></li>";
echo "<li>Enter credentials: Mobile: 9876543210, Password: admin123</li>";
echo "<li>Click Sign In</li>";
echo "<li>Click Continue on the success dialog</li>";
echo "<li>You should be redirected to dashboard.html</li>";
echo "<li>The page should show the dashboard with the original design</li>";
echo "</ol>";

echo "<h3>6. What Was Fixed</h3>";
echo "<ul>";
echo "<li>✅ Login now redirects to dashboard.html</li>";
echo "<li>✅ Navigation link in dashboard.html points to dashboard.html</li>";
echo "<li>✅ No authentication wrapper - direct access to dashboard</li>";
echo "</ul>";

echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 