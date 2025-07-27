<?php
// Test database connection with new port
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_management";
$port = 3307;

echo "<h2>Testing Database Connection</h2>";
echo "<p>Attempting to connect to MySQL on port $port...</p>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Connection failed: " . $conn->connect_error . "</p>";
} else {
    echo "<p style='color: green;'>✅ Connection successful!</p>";
    
    // Test a simple query
    $sql = "SHOW TABLES";
    $result = $conn->query($sql);
    
    if ($result) {
        echo "<p>📋 Database tables found:</p>";
        echo "<ul>";
        while ($row = $result->fetch_array()) {
            echo "<li>" . $row[0] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: orange;'>⚠️ Could not fetch tables: " . $conn->error . "</p>";
    }
}

$conn->close();
echo "<p><strong>Test completed.</strong></p>";
?> 