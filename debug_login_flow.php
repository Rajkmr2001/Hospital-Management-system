<?php
// Debug script to test login flow
session_start();

echo "<h2>Login Flow Debug</h2>";

// Test 1: Check if we can access the login.php file
echo "<h3>1. Testing Login PHP File</h3>";
$login_file = 'hospital-admin-panel/admin/php/login.php';
if (file_exists($login_file)) {
    echo "<p style='color: green;'>✅ Login PHP file exists</p>";
} else {
    echo "<p style='color: red;'>❌ Login PHP file not found</p>";
}

// Test 2: Check if we can access the dashboard.php file
echo "<h3>2. Testing Dashboard PHP File</h3>";
$dashboard_file = 'hospital-admin-panel/admin/dashboard.php';
if (file_exists($dashboard_file)) {
    echo "<p style='color: green;'>✅ Dashboard PHP file exists</p>";
} else {
    echo "<p style='color: red;'>❌ Dashboard PHP file not found</p>";
}

// Test 3: Check if we can access the auth_check.php file
echo "<h3>3. Testing Auth Check PHP File</h3>";
$auth_file = 'hospital-admin-panel/admin/php/auth_check.php';
if (file_exists($auth_file)) {
    echo "<p style='color: green;'>✅ Auth check PHP file exists</p>";
} else {
    echo "<p style='color: red;'>❌ Auth check PHP file not found</p>";
}

// Test 4: Check current session
echo "<h3>4. Current Session Status</h3>";
if (isset($_SESSION['admin_id']) && isset($_SESSION['admin_username'])) {
    echo "<p style='color: green;'>✅ User is logged in</p>";
    echo "<ul>";
    echo "<li>Admin ID: " . $_SESSION['admin_id'] . "</li>";
    echo "<li>Admin Username: " . $_SESSION['admin_username'] . "</li>";
    echo "</ul>";
} else {
    echo "<p style='color: orange;'>⚠️ User is not logged in</p>";
}

// Test 5: Test database connection
echo "<h3>5. Database Connection Test</h3>";
include 'db/config.php';
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
} else {
    echo "<p style='color: green;'>✅ Database connection successful</p>";
    
    // Test if admin user exists
    $stmt = $conn->prepare("SELECT id, username, mobile_number FROM admins WHERE username = 'admin'");
    if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            echo "<p style='color: green;'>✅ Admin user found</p>";
            echo "<ul>";
            echo "<li>ID: " . $admin['id'] . "</li>";
            echo "<li>Username: " . $admin['username'] . "</li>";
            echo "<li>Mobile: " . $admin['mobile_number'] . "</li>";
            echo "</ul>";
        } else {
            echo "<p style='color: red;'>❌ No admin user found</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>❌ Could not prepare statement</p>";
    }
}
$conn->close();

// Test 6: Test direct access to dashboard
echo "<h3>6. Dashboard Access Test</h3>";
echo "<p><strong>Test Links:</strong></p>";
echo "<ul>";
echo "<li><a href='hospital-admin-panel/admin/dashboard.php' target='_blank'>Direct Dashboard Access</a></li>";
echo "<li><a href='hospital-admin-panel/admin/login.html' target='_blank'>Login Page</a></li>";
echo "</ul>";

// Test 7: Simulate login process
echo "<h3>7. Simulate Login Process</h3>";
echo "<p>To test the complete flow:</p>";
echo "<ol>";
echo "<li>Go to <a href='hospital-admin-panel/admin/login.html' target='_blank'>Login Page</a></li>";
echo "<li>Enter credentials: Mobile: 9876543210, Password: admin123</li>";
echo "<li>Click Sign In</li>";
echo "<li>Check if you're redirected to dashboard</li>";
echo "</ol>";

echo "<hr>";
echo "<h3>Debug Information</h3>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "</p>";

echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 