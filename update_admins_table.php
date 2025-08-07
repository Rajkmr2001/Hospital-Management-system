<?php
// Migration script to add mobile_number column to existing admins table
// This script will update the existing table structure and add mobile number to existing admin

include 'db/config.php';

echo "<h2>Admin Table Migration</h2>";
echo "<p>Updating admins table to include mobile number field...</p>";

// Check if mobile_number column exists
$check_column_sql = "SHOW COLUMNS FROM admins LIKE 'mobile_number'";
$result = $conn->query($check_column_sql);

if ($result->num_rows == 0) {
    // Add mobile_number column
    $add_column_sql = "ALTER TABLE admins ADD COLUMN mobile_number VARCHAR(15) NOT NULL UNIQUE AFTER username";
    
    if ($conn->query($add_column_sql) === TRUE) {
        echo "<p style='color: green;'>✅ Mobile number column added successfully!</p>";
    } else {
        echo "<p style='color: red;'>❌ Error adding mobile number column: " . $conn->error . "</p>";
        $conn->close();
        exit();
    }
} else {
    echo "<p style='color: blue;'>ℹ️ Mobile number column already exists.</p>";
}

// Update existing admin user with mobile number
$update_admin_sql = "UPDATE admins SET mobile_number = '9876543210' WHERE username = 'admin'";
if ($conn->query($update_admin_sql) === TRUE) {
    echo "<p style='color: green;'>✅ Default admin mobile number updated!</p>";
} else {
    echo "<p style='color: orange;'>⚠️ Warning updating admin mobile number: " . $conn->error . "</p>";
}

// Create index for mobile number if it doesn't exist
$check_index_sql = "SHOW INDEX FROM admins WHERE Key_name = 'idx_admins_mobile'";
$index_result = $conn->query($check_index_sql);

if ($index_result->num_rows == 0) {
    $create_index_sql = "CREATE INDEX idx_admins_mobile ON admins(mobile_number)";
    if ($conn->query($create_index_sql) === TRUE) {
        echo "<p style='color: green;'>✅ Mobile number index created successfully!</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Warning creating mobile index: " . $conn->error . "</p>";
    }
} else {
    echo "<p style='color: blue;'>ℹ️ Mobile number index already exists.</p>";
}

$conn->close();

echo "<hr>";
echo "<h3>Migration Complete!</h3>";
echo "<p>Your admins table has been updated successfully.</p>";
echo "<p><strong>Updated Login Credentials:</strong></p>";
echo "<ul>";
echo "<li><strong>Mobile Number:</strong> 9876543210</li>";
echo "<li><strong>Password:</strong> admin123</li>";
echo "</ul>";
echo "<p>You can now login using your mobile number instead of username.</p>";
echo "<p><a href='hospital-admin-panel/admin/login.php' target='_blank'>Go to Admin Login</a></p>";
echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 