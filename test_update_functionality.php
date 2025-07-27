<?php
// Test script to verify patient update functionality
include 'db/config.php';

echo "<h2>Patient Update Functionality Test</h2>";

// Test with a sample mobile number (replace with an actual one from your database)
$test_mobile = "9142420000"; // Replace with an actual mobile number from your database

echo "<p>Testing update functionality for mobile: <strong>$test_mobile</strong></p>";

// Check current data
$stmt = $conn->prepare("SELECT * FROM patient_register WHERE mobile_no = ?");
$stmt->bind_param("s", $test_mobile);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "<p style='color: green;'>✅ User found in patient_register!</p>";
    echo "<p><strong>Current Name:</strong> " . $user['name'] . "</p>";
    echo "<p><strong>Current Gender:</strong> " . $user['gender'] . "</p>";
    
    // Check patient_data table
    $stmt2 = $conn->prepare("SELECT * FROM patient_data WHERE contact = ?");
    $stmt2->bind_param("s", $test_mobile);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    
    if ($result2->num_rows > 0) {
        $patient_data = $result2->fetch_assoc();
        echo "<p style='color: green;'>✅ User found in patient_data!</p>";
        echo "<p><strong>Age:</strong> " . ($patient_data['age'] ?? 'NULL') . "</p>";
        echo "<p><strong>Address:</strong> " . ($patient_data['address'] ?? 'NULL') . "</p>";
        echo "<p><strong>Medical History:</strong> " . ($patient_data['medical_history'] ?? 'NULL') . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ User not found in patient_data (will be created on first update)</p>";
    }
    $stmt2->close();
    
} else {
    echo "<p style='color: red;'>❌ User not found with mobile: $test_mobile</p>";
    echo "<p>Please replace the mobile number in this script with an actual one from your database.</p>";
}

$stmt->close();

echo "<hr>";
echo "<h3>Database Tables Structure</h3>";
echo "<p><strong>patient_register table:</strong> Basic registration info (name, gender, mobile, password)</p>";
echo "<p><strong>patient_data table:</strong> Additional patient info (age, address, medical_history)</p>";
echo "<p>When a patient updates their information, both tables are updated to keep data synchronized.</p>";

echo "<hr>";
echo "<h3>How to Test</h3>";
echo "<ol>";
echo "<li>Login to patient dashboard with a registered mobile number</li>";
echo "<li>Click the 'Edit' button in the Personal Information section</li>";
echo "<li>Update any fields (name, age, gender, address, medical history)</li>";
echo "<li>Click 'Update Information'</li>";
echo "<li>Check that the changes appear in both the dashboard and admin panel</li>";
echo "</ol>";

$conn->close();
?> 