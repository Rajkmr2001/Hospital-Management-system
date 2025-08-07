<?php
// Admin Authentication Setup Script
// This script will create the admins table and insert a default admin user

include 'db/config.php';

echo "<h2>Admin Authentication Setup</h2>";
echo "<p>Setting up admin authentication system...</p>";

// Create admins table
$create_table_sql = "
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    mobile_number VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100),
    role VARCHAR(50) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if ($conn->query($create_table_sql) === TRUE) {
    echo "<p style='color: green;'>✅ Admins table created successfully!</p>";
} else {
    echo "<p style='color: red;'>❌ Error creating admins table: " . $conn->error . "</p>";
}

// Insert default admin user
$default_username = 'admin';
$default_mobile = '9876543210';
$default_password = 'admin123';
$hashed_password = password_hash($default_password, PASSWORD_DEFAULT);

$insert_admin_sql = "
INSERT INTO admins (username, mobile_number, password, email, full_name, role) VALUES 
(?, ?, ?, 'admin@maakalawati.com', 'System Administrator', 'admin')
ON DUPLICATE KEY UPDATE username=username;
";

$stmt = $conn->prepare($insert_admin_sql);
$stmt->bind_param("sss", $default_username, $default_mobile, $hashed_password);

if ($stmt->execute()) {
    echo "<p style='color: green;'>✅ Default admin user created successfully!</p>";
    echo "<p><strong>Default Login Credentials:</strong></p>";
    echo "<ul>";
    echo "<li><strong>Mobile Number:</strong> 9876543210</li>";
    echo "<li><strong>Password:</strong> admin123</li>";
    echo "</ul>";
} else {
    echo "<p style='color: red;'>❌ Error creating admin user: " . $stmt->error . "</p>";
}

$stmt->close();

// Create indexes for better performance
$indexes = [
    "CREATE INDEX IF NOT EXISTS idx_admins_username ON admins(username)",
    "CREATE INDEX IF NOT EXISTS idx_admins_mobile ON admins(mobile_number)",
    "CREATE INDEX IF NOT EXISTS idx_admins_active ON admins(is_active)"
];

foreach ($indexes as $index_sql) {
    if ($conn->query($index_sql) === TRUE) {
        echo "<p style='color: green;'>✅ Index created successfully!</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Index creation warning: " . $conn->error . "</p>";
    }
}

$conn->close();

echo "<hr>";
echo "<h3>Setup Complete!</h3>";
echo "<p>Your admin authentication system is now ready. You can:</p>";
echo "<ol>";
echo "<li>Go to <a href='hospital-admin-panel/admin/login.php' target='_blank'>Admin Login</a></li>";
echo "<li>Use the credentials: <strong>9876543210</strong> / <strong>admin123</strong></li>";
echo "<li>Access the protected dashboard</li>";
echo "</ol>";
echo "<p><strong>Important:</strong> Please change the default password after your first login for security!</p>";
echo "<p><a href='index.html'>← Back to Home</a></p>";
?> 