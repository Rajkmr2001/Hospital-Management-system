<?php
// Test script to check dashboard path issues
echo "<h2>🔍 Dashboard Path Test</h2>";

// Test 1: Check if dashboard_auth.php exists
echo "<h3>1. File Existence Check</h3>";
$dashboard_auth_path = 'hospital-admin-panel/admin/dashboard_auth.php';
if (file_exists($dashboard_auth_path)) {
    echo "<p style='color: green;'>✅ dashboard_auth.php exists at: $dashboard_auth_path</p>";
    
    // Check file permissions
    if (is_readable($dashboard_auth_path)) {
        echo "<p style='color: green;'>✅ File is readable</p>";
    } else {
        echo "<p style='color: red;'>❌ File is not readable</p>";
    }
} else {
    echo "<p style='color: red;'>❌ dashboard_auth.php not found at: $dashboard_auth_path</p>";
}

// Test 2: Check current directory structure
echo "<h3>2. Directory Structure</h3>";
echo "<p>Current working directory: " . getcwd() . "</p>";

// Test 3: Test the redirect path from login.php perspective
echo "<h3>3. Redirect Path Test</h3>";
echo "<p>From login.php (hospital-admin-panel/admin/php/login.php):</p>";
echo "<p>Current redirect path: <code>../dashboard_auth.php</code></p>";

// Calculate what this path should resolve to
$login_dir = 'hospital-admin-panel/admin/php/';
$redirect_path = '../dashboard_auth.php';
$resolved_path = realpath($login_dir . $redirect_path);

if ($resolved_path) {
    echo "<p style='color: green;'>✅ Resolved path: $resolved_path</p>";
} else {
    echo "<p style='color: red;'>❌ Could not resolve path: $login_dir$redirect_path</p>";
}

// Test 4: Check if we can access dashboard_auth.php directly
echo "<h3>4. Direct Access Test</h3>";
echo "<ul>";
echo "<li><a href='hospital-admin-panel/admin/dashboard_auth.php' target='_blank'>🔗 Direct Access to dashboard_auth.php</a></li>";
echo "<li><a href='hospital-admin-panel/admin/dashboard.html' target='_blank'>🔗 Direct Access to dashboard.html</a></li>";
echo "</ul>";

// Test 5: Check login.php redirect path
echo "<h3>5. Login Redirect Path Check</h3>";
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
    }
} else {
    echo "<p style='color: red;'>❌ login.php not found</p>";
}

echo "<hr>";
echo "<p><strong>🎯 Next Steps:</strong></p>";
echo "<ol>";
echo "<li>Click the direct access links above to test</li>";
echo "<li>If dashboard_auth.php works directly, the issue is with the redirect path</li>";
echo "<li>If dashboard_auth.php doesn't work, there's an issue with the file itself</li>";
echo "</ol>";
echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 