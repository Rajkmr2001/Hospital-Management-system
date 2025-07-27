<?php
// Test script to verify patient login functionality
include 'db/config.php';

echo "<h2>Patient Login Test</h2>";

// Test with a sample mobile number (replace with an actual one from your database)
$test_mobile = "9876543210"; // Replace with an actual mobile number from your database

echo "<p>Testing login for mobile: $test_mobile</p>";

// Check if user exists
$stmt = $conn->prepare("SELECT * FROM patient_register WHERE mobile_no = ?");
$stmt->bind_param("s", $test_mobile);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "<p>✅ User found: " . $user['name'] . "</p>";
    echo "<p>Password hash: " . substr($user['password'], 0, 20) . "...</p>";
    
    // Test password verification
    $test_password = "password123"; // Replace with the actual password you want to test
    echo "<p>Testing password: $test_password</p>";
    
    if (password_verify($test_password, $user['password'])) {
        echo "<p>✅ Password verification successful!</p>";
    } else {
        echo "<p>❌ Password verification failed!</p>";
        echo "<p>This means either:</p>";
        echo "<ul>";
        echo "<li>The password you're testing is incorrect</li>";
        echo "<li>The password was not hashed properly during registration</li>";
        echo "</ul>";
    }
} else {
    echo "<p>❌ User not found with mobile: $test_mobile</p>";
    echo "<p>Please replace the mobile number in this script with an actual one from your database.</p>";
}

$stmt->close();
$conn->close();

echo "<hr>";
echo "<h3>Available users in database:</h3>";
echo "<p>Run this query in phpMyAdmin to see all registered users:</p>";
echo "<code>SELECT mobile_no, name, LEFT(password, 20) as password_preview FROM patient_register;</code>";
?> 