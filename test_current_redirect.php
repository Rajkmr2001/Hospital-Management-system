<?php
// Test script to check current login redirect
session_start();

echo "<h2>🔍 Current Login Redirect Test</h2>";

// Test 1: Check login.php redirect path
echo "<h3>1. Login Redirect Path</h3>";
$login_file = 'hospital-admin-panel/admin/php/login.php';
if (file_exists($login_file)) {
    $content = file_get_contents($login_file);
    if (preg_match("/'redirect' => '([^']+)'/", $content, $matches)) {
        $current_redirect = $matches[1];
        echo "<p>Current redirect in login.php: <code>$current_redirect</code></p>";
        
        // Test if this path would work
        $test_path = 'hospital-admin-panel/admin/php/' . $current_redirect;
        if (file_exists($test_path)) {
            echo "<p style='color: green;'>✅ Redirect path resolves to existing file</p>";
        } else {
            echo "<p style='color: red;'>❌ Redirect path does not resolve to existing file</p>";
            echo "<p>Expected file: $test_path</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Could not find redirect path in login.php</p>";
    }
} else {
    echo "<p style='color: red;'>❌ login.php not found</p>";
}

// Test 2: Check current session
echo "<h3>2. Current Session Status</h3>";
if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username'])) {
    echo "<p style='color: green;'>✅ User is logged in</p>";
    echo "<ul>";
    echo "<li>Admin ID: " . $_SESSION['admin_id'] . "</li>";
    echo "<li>Admin Username: " . $_SESSION['admin_username'] . "</li>";
    echo "</ul>";
} else {
    echo "<p style='color: orange;'>⚠️ User is not logged in</p>";
}

// Test 3: Test direct access to dashboard_auth.php
echo "<h3>3. Dashboard Auth Direct Access</h3>";
$dashboard_auth_file = 'hospital-admin-panel/admin/dashboard_auth.php';
if (file_exists($dashboard_auth_file)) {
    echo "<p style='color: green;'>✅ dashboard_auth.php exists</p>";
    echo "<p><a href='$dashboard_auth_file' target='_blank'>🔗 Test Direct Access</a></p>";
} else {
    echo "<p style='color: red;'>❌ dashboard_auth.php not found</p>";
}

// Test 4: Simulate the complete login flow
echo "<h3>4. Complete Login Flow Test</h3>";
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #007bff;'>";
echo "<h4>Step-by-Step Test:</h4>";
echo "<ol>";
echo "<li><a href='hospital-admin-panel/admin/login.html' target='_blank'>🔑 Go to Login Page</a></li>";
echo "<li>Enter credentials: <strong>Mobile: 9876543210, Password: admin123</strong></li>";
echo "<li>Click 'Sign In'</li>";
echo "<li>Click 'Continue' on success dialog</li>";
echo "<li>You should be redirected to: <code>dashboard_auth.php</code></li>";
echo "</ol>";
echo "</div>";

// Test 5: Check what URL you're currently accessing
echo "<h3>5. Current URL Analysis</h3>";
echo "<p>If you're seeing 'dashboard.html' in the URL, it means:</p>";
echo "<ul>";
echo "<li>❌ You're accessing the wrong URL</li>";
echo "<li>❌ The redirect is not working properly</li>";
echo "<li>❌ You should be accessing <code>dashboard_auth.php</code></li>";
echo "</ul>";

// Test 6: Manual redirect test
echo "<h3>6. Manual Redirect Test</h3>";
if (isset($_SESSION['admin_id'])) {
    echo "<p style='color: green;'>✅ You are logged in!</p>";
    echo "<p><a href='hospital-admin-panel/admin/dashboard_auth.php' target='_blank'>🛡️ Access Protected Dashboard</a></p>";
    echo "<p><a href='hospital-admin-panel/admin/dashboard.html' target='_blank'>📄 Access Direct Dashboard (No Protection)</a></p>";
} else {
    echo "<p style='color: orange;'>⚠️ You need to log in first</p>";
    echo "<p><a href='hospital-admin-panel/admin/login.html' target='_blank'>🔑 Go to Login</a></p>";
}

echo "<hr>";
echo "<p><strong>🎯 Key Point:</strong> With authentication wrapper, you should <strong>always</strong> access <code>dashboard_auth.php</code>, not <code>dashboard.html</code>!</p>";
echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 