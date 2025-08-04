<?php
// Simple debug file to test data loading
session_start();

echo "<h2>Patient Dashboard Data Debug</h2>";

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
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'hospital_management';
$port = 3306;

$conn = new mysqli($host, $user, $password, $dbname, $port);
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
    exit();
} else {
    echo "<p style='color: green;'>✅ Database connection successful</p>";
}

// Test patient data
$patient_mobile = $_SESSION['patient_mobile'];
echo "<h3>Patient Data Test:</h3>";

// Test patient_register
$stmt = $conn->prepare("SELECT * FROM patient_register WHERE mobile_no = ?");
$stmt->bind_param("s", $patient_mobile);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $patient = $result->fetch_assoc();
    echo "<p style='color: green;'>✅ Patient found in patient_register:</p>";
    echo "<ul>";
    echo "<li>Name: " . $patient['name'] . "</li>";
    echo "<li>Mobile: " . $patient['mobile_no'] . "</li>";
    echo "<li>Gender: " . $patient['gender'] . "</li>";
    echo "<li>Register Date: " . $patient['register_date'] . "</li>";
    echo "</ul>";
} else {
    echo "<p style='color: red;'>❌ Patient NOT found in patient_register</p>";
}
$stmt->close();

// Test patient_data
$stmt = $conn->prepare("SELECT * FROM patient_data WHERE contact = ?");
$stmt->bind_param("s", $patient_mobile);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $patient_data = $result->fetch_assoc();
    echo "<p style='color: green;'>✅ Patient found in patient_data:</p>";
    echo "<ul>";
    echo "<li>Name: " . $patient_data['name'] . "</li>";
    echo "<li>Age: " . $patient_data['age'] . "</li>";
    echo "<li>Address: " . $patient_data['address'] . "</li>";
    echo "</ul>";
} else {
    echo "<p style='color: orange;'>⚠️ Patient NOT found in patient_data</p>";
}
$stmt->close();

// Test API response
echo "<h3>API Response Test:</h3>";
echo "<p><a href='get_patient_dashboard_data.php' target='_blank'>Test get_patient_dashboard_data.php</a></p>";

$conn->close();
?> 