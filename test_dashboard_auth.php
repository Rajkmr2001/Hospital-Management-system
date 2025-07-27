<?php
// Test script to verify dashboard authentication setup
session_start();

echo "<h2>Dashboard Authentication Test</h2>";

// Test 1: Check if dashboard.html exists
echo "<h3>1. Dashboard Files Check</h3>";
$dashboard_html = 'hospital-admin-panel/admin/dashboard.html';
$dashboard_auth = 'hospital-admin-panel/admin/dashboard_auth.php';

if (file_exists($dashboard_html)) {
    echo "<p style='color: green;'>✅ dashboard.html exists</p>";
} else {
    echo "<p style='color: red;'>❌ dashboard.html not found</p>";
}

if (file_exists($dashboard_auth)) {
    echo "<p style='color: green;'>✅ dashboard_auth.php exists</p>";
} else {
    echo "<p style='color: red;'>❌ dashboard_auth.php not found</p>";
}

// Test 2: Check current session
echo "<h3>2. Session Status</h3>";
if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username'])) {
    echo "<p style='color: green;'>✅ User is logged in</p>";
    echo "<ul>";
    echo "<li>Admin ID: " . $_SESSION['admin_id'] . "</li>";
    echo "<li>Admin Username: " . $_SESSION['admin_username'] . "</li>";
    echo "</ul>";
} else {
    echo "<p style='color: orange;'>⚠️ User is not logged in</p>";
}

// Test 3: Test links
echo "<h3>3. Test Links</h3>";
echo "<ul>";
echo "<li><a href='hospital-admin-panel/admin/dashboard_auth.php' target='_blank'>Dashboard (Authenticated)</a> - Should work if logged in</li>";
echo "<li><a href='hospital-admin-panel/admin/dashboard.html' target='_blank'>Dashboard (Direct HTML)</a> - Should work but no auth</li>";
echo "<li><a href='hospital-admin-panel/admin/login.html' target='_blank'>Login Page</a></li>";
echo "</ul>";

// Test 4: Instructions
echo "<h3>4. How It Works</h3>";
echo "<ol>";
echo "<li>User logs in via login.html</li>";
echo "<li>Login redirects to dashboard_auth.php</li>";
echo "<li>dashboard_auth.php checks authentication</li>";
echo "<li>If authenticated, it serves dashboard.html content</li>";
echo "<li>If not authenticated, it redirects to login.html</li>";
echo "</ol>";

echo "<h3>5. Testing Instructions</h3>";
echo "<ol>";
echo "<li>Go to <a href='hospital-admin-panel/admin/login.html' target='_blank'>Login Page</a></li>";
echo "<li>Enter credentials: Mobile: 9876543210, Password: admin123</li>";
echo "<li>Click Sign In</li>";
echo "<li>You should be redirected to dashboard_auth.php</li>";
echo "<li>The page should show the original dashboard.html design</li>";
echo "</ol>";

echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 