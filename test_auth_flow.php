<?php
// Test script to verify authentication flow
session_start();

echo "<h2>🔐 Authentication Flow Test</h2>";

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

// Test 2: Test auth_check.php directly
echo "<h3>2. Auth Check Test</h3>";
$auth_check_file = 'hospital-admin-panel/admin/php/auth_check.php';
if (file_exists($auth_check_file)) {
    echo "<p style='color: green;'>✅ auth_check.php exists</p>";
    
    // Test if it can be included without errors
    ob_start();
    try {
        include $auth_check_file;
        $output = ob_get_clean();
        echo "<p style='color: green;'>✅ auth_check.php can be included successfully</p>";
    } catch (Exception $e) {
        $output = ob_get_clean();
        echo "<p style='color: red;'>❌ Error including auth_check.php: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ auth_check.php not found</p>";
}

// Test 3: Test dashboard_auth.php directly
echo "<h3>3. Dashboard Auth Test</h3>";
$dashboard_auth_file = 'hospital-admin-panel/admin/dashboard_auth.php';
if (file_exists($dashboard_auth_file)) {
    echo "<p style='color: green;'>✅ dashboard_auth.php exists</p>";
    
    // Test if it can be included without errors
    ob_start();
    try {
        include $dashboard_auth_file;
        $output = ob_get_clean();
        echo "<p style='color: green;'>✅ dashboard_auth.php can be included successfully</p>";
        echo "<p>Output length: " . strlen($output) . " characters</p>";
    } catch (Exception $e) {
        $output = ob_get_clean();
        echo "<p style='color: red;'>❌ Error including dashboard_auth.php: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ dashboard_auth.php not found</p>";
}

// Test 4: Check database connection
echo "<h3>4. Database Connection Test</h3>";
$config_file = 'db/config.php';
if (file_exists($config_file)) {
    echo "<p style='color: green;'>✅ config.php exists</p>";
    
    try {
        include $config_file;
        if (isset($conn) && $conn->ping()) {
            echo "<p style='color: green;'>✅ Database connection successful</p>";
            
            // Test admins table
            $result = $conn->query("SHOW TABLES LIKE 'admins'");
            if ($result->num_rows > 0) {
                echo "<p style='color: green;'>✅ admins table exists</p>";
                
                // Check table structure
                $columns = $conn->query("SHOW COLUMNS FROM admins");
                echo "<p>Table columns:</p><ul>";
                while ($column = $columns->fetch_assoc()) {
                    echo "<li>" . $column['Field'] . " (" . $column['Type'] . ")</li>";
                }
                echo "</ul>";
            } else {
                echo "<p style='color: red;'>❌ admins table does not exist</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Database connection failed</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Database error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ config.php not found</p>";
}

// Test 5: Test URLs
echo "<h3>5. URL Test</h3>";
echo "<ul>";
echo "<li><a href='hospital-admin-panel/admin/login.html' target='_blank'>🔑 Login Page</a></li>";
echo "<li><a href='hospital-admin-panel/admin/dashboard_auth.php' target='_blank'>🛡️ Dashboard (Protected)</a></li>";
echo "<li><a href='hospital-admin-panel/admin/dashboard.html' target='_blank'>📄 Dashboard (Direct)</a></li>";
echo "</ul>";

// Test 6: Simulate login process
echo "<h3>6. Login Process Test</h3>";
if (!isset($_SESSION['admin_id'])) {
    echo "<p>To test the complete flow:</p>";
    echo "<ol>";
    echo "<li>Go to <a href='hospital-admin-panel/admin/login.html' target='_blank'>Login Page</a></li>";
    echo "<li>Enter credentials: <strong>Mobile: 9876543210, Password: admin123</strong></li>";
    echo "<li>Click Sign In</li>";
    echo "<li>Click Continue on success dialog</li>";
    echo "<li>You should be redirected to dashboard_auth.php</li>";
    echo "</ol>";
} else {
    echo "<p style='color: green;'>✅ You are already logged in! <a href='hospital-admin-panel/admin/dashboard_auth.php' target='_blank'>Access Dashboard</a></p>";
}

echo "<hr>";
echo "<p><strong>🎯 Summary:</strong> This test helps identify where the authentication flow might be failing.</p>";
echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 