<?php
// Test script to verify admin login system
include 'db/config.php';

echo "<h2>Admin Login System Test</h2>";
echo "<p>Testing the admin authentication system...</p>";

// Test 1: Check database connection
echo "<h3>1. Database Connection Test</h3>";
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
    exit();
} else {
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
}

// Test 2: Check if admins table exists
echo "<h3>2. Admins Table Test</h3>";
$table_check = $conn->query("SHOW TABLES LIKE 'admins'");
if ($table_check->num_rows == 0) {
    echo "<p style='color: red;'>❌ Admins table does not exist!</p>";
    echo "<p>Please run <a href='setup_admin_auth.php'>setup_admin_auth.php</a> first.</p>";
} else {
    echo "<p style='color: green;'>✅ Admins table exists!</p>";
}

// Test 3: Check table structure
echo "<h3>3. Table Structure Test</h3>";
$structure_check = $conn->query("DESCRIBE admins");
if ($structure_check) {
    echo "<p style='color: green;'>✅ Table structure:</p>";
    echo "<ul>";
    while ($row = $structure_check->fetch_assoc()) {
        $required = $row['Null'] === 'NO' ? ' (Required)' : '';
        echo "<li><strong>{$row['Field']}</strong> - {$row['Type']}{$required}</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color: red;'>❌ Could not check table structure: " . $conn->error . "</p>";
}

// Test 4: Check if mobile_number column exists
echo "<h3>4. Mobile Number Column Test</h3>";
$column_check = $conn->query("SHOW COLUMNS FROM admins LIKE 'mobile_number'");
if ($column_check->num_rows == 0) {
    echo "<p style='color: red;'>❌ Mobile number column does not exist!</p>";
    echo "<p>Please run <a href='update_admins_table.php'>update_admins_table.php</a> to add the column.</p>";
} else {
    echo "<p style='color: green;'>✅ Mobile number column exists!</p>";
}

// Test 5: Check if admin user exists
echo "<h3>5. Admin User Test</h3>";
$user_check = $conn->query("SELECT id, username, mobile_number, is_active FROM admins WHERE username = 'admin'");
if ($user_check->num_rows == 0) {
    echo "<p style='color: red;'>❌ No admin user found!</p>";
    echo "<p>Please run <a href='setup_admin_auth.php'>setup_admin_auth.php</a> to create the admin user.</p>";
} else {
    $admin = $user_check->fetch_assoc();
    echo "<p style='color: green;'>✅ Admin user found!</p>";
    echo "<ul>";
    echo "<li><strong>ID:</strong> {$admin['id']}</li>";
    echo "<li><strong>Username:</strong> {$admin['username']}</li>";
    echo "<li><strong>Mobile Number:</strong> {$admin['mobile_number']}</li>";
    echo "<li><strong>Active:</strong> " . ($admin['is_active'] ? 'Yes' : 'No') . "</li>";
    echo "</ul>";
}

// Test 6: Test prepared statement
echo "<h3>6. Prepared Statement Test</h3>";
$stmt = $conn->prepare("SELECT * FROM admins WHERE mobile_number = ? LIMIT 1");
if ($stmt === false) {
    echo "<p style='color: red;'>❌ Prepared statement failed: " . $conn->error . "</p>";
} else {
    echo "<p style='color: green;'>✅ Prepared statement works!</p>";
    
    // Test with the default mobile number
    $test_mobile = '9876543210';
    $stmt->bind_param("s", $test_mobile);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo "<p style='color: green;'>✅ Query executed successfully!</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Query executed but no user found with mobile number: {$test_mobile}</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Query execution failed: " . $stmt->error . "</p>";
    }
    
    $stmt->close();
}

$conn->close();

echo "<hr>";
echo "<h3>Test Summary</h3>";
echo "<p>If all tests passed, your admin login system should be working correctly.</p>";
echo "<p><strong>Test the login:</strong> <a href='hospital-admin-panel/admin/login.html' target='_blank'>Go to Admin Login</a></p>";
echo "<p><strong>Default credentials:</strong> Mobile: 9876543210, Password: admin123</p>";
echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 