<?php
// Test script to verify login redirect fix
session_start();

echo "<h2>Login Redirect Fix Test</h2>";

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
    if (strpos($content, "'redirect' => '../dashboard_auth.php'") !== false) {
        echo "<p style='color: green;'>✅ Login redirects to dashboard_auth.php</p>";
    } else {
        echo "<p style='color: red;'>❌ Login redirect path is incorrect</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Login.php file not found</p>";
}

// Test 3: Check dashboard files
echo "<h3>3. Dashboard Files Check</h3>";
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

// Test 4: Test links
echo "<h3>4. Test Links</h3>";
echo "<ul>";
echo "<li><a href='hospital-admin-panel/admin/login.html' target='_blank'>Login Page</a></li>";
echo "<li><a href='hospital-admin-panel/admin/dashboard_auth.php' target='_blank'>Dashboard (Authenticated)</a></li>";
echo "<li><a href='hospital-admin-panel/admin/dashboard.html' target='_blank'>Dashboard (Direct HTML)</a></li>";
echo "</ul>";

// Test 5: Instructions
echo "<h3>5. How to Test</h3>";
echo "<ol>";
echo "<li>Go to <a href='hospital-admin-panel/admin/login.html' target='_blank'>Login Page</a></li>";
echo "<li>Enter credentials: Mobile: 9876543210, Password: admin123</li>";
echo "<li>Click Sign In</li>";
echo "<li>Click Continue on the success dialog</li>";
echo "<li>You should be redirected to dashboard_auth.php</li>";
echo "<li>The page should show the dashboard with your username</li>";
echo "</ol>";

echo "<h3>6. What Was Fixed</h3>";
echo "<ul>";
echo "<li>✅ Login now redirects to dashboard_auth.php instead of dashboard.html</li>";
echo "<li>✅ dashboard_auth.php includes authentication check</li>";
echo "<li>✅ If not authenticated, it redirects to login.html</li>";
echo "<li>✅ If authenticated, it serves dashboard.html content with dynamic username</li>";
echo "<li>✅ Navigation link in dashboard.html points to dashboard_auth.php</li>";
echo "</ul>";

echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 