<?php
// Debug current state
session_start();
header('Content-Type: text/html');

echo "<h2>Current State Debug</h2>";

// Check session
echo "<h3>Session Data:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// Check if logged in
if (isset($_SESSION['patient_logged_in']) && $_SESSION['patient_logged_in'] === true) {
    echo "<p style='color: green;'>✅ Patient is logged in</p>";
    echo "<p>Mobile: " . ($_SESSION['patient_mobile'] ?? 'NOT SET') . "</p>";
    echo "<p>Name: " . ($_SESSION['patient_name'] ?? 'NOT SET') . "</p>";
} else {
    echo "<p style='color: red;'>❌ Patient is NOT logged in</p>";
    echo "<p><a href='patient_login.html'>Go to Login</a></p>";
    exit();
}

// Test database connection
echo "<h3>Database Test:</h3>";
$conn = new mysqli('localhost', 'root', '', 'hospital_management', 3306);
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ DB Error: " . $conn->connect_error . "</p>";
    exit();
} else {
    echo "<p style='color: green;'>✅ DB Connected</p>";
}

// Test patient data
$mobile = $_SESSION['patient_mobile'];
echo "<h3>Patient Data Test:</h3>";

// Check patient_register
$stmt = $conn->prepare("SELECT * FROM patient_register WHERE mobile_no = ?");
$stmt->bind_param("s", $mobile);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $patient = $result->fetch_assoc();
    echo "<p style='color: green;'>✅ Patient found in patient_register</p>";
    echo "<p>Name: " . $patient['name'] . "</p>";
    echo "<p>Mobile: " . $patient['mobile_no'] . "</p>";
} else {
    echo "<p style='color: red;'>❌ Patient NOT found in patient_register</p>";
}

// Check patient_data
$stmt = $conn->prepare("SELECT * FROM patient_data WHERE contact = ?");
$stmt->bind_param("s", $mobile);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $patient_data = $result->fetch_assoc();
    echo "<p style='color: green;'>✅ Patient found in patient_data</p>";
    echo "<p>Age: " . ($patient_data['age'] ?? 'N/A') . "</p>";
    echo "<p>Gender: " . ($patient_data['gender'] ?? 'N/A') . "</p>";
    echo "<p>Address: " . ($patient_data['address'] ?? 'N/A') . "</p>";
} else {
    echo "<p style='color: orange;'>⚠️ Patient NOT found in patient_data (this is okay for new patients)</p>";
}

// Test API endpoints
echo "<h3>API Test:</h3>";
echo "<p><a href='check_patient_auth.php' target='_blank'>Test Authentication API</a></p>";
echo "<p><a href='get_patient_dashboard_data.php' target='_blank'>Test Data API</a></p>";

// Test dashboard
echo "<h3>Dashboard Test:</h3>";
echo "<p><a href='patient_dashboard.html' target='_blank'>Open Dashboard</a></p>";
echo "<p><a href='test_dashboard_js.html' target='_blank'>Test JavaScript</a></p>";

$conn->close();
?> 