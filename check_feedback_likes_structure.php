<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_management";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "=== feedback_likes table structure ===\n";
$result = $conn->query("DESCRIBE feedback_likes");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} else {
    echo "Error: " . $conn->error . "\n";
}

echo "\n=== Sample data from feedback_likes ===\n";
$result = $conn->query("SELECT * FROM feedback_likes LIMIT 5");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "No data found or error: " . $conn->error . "\n";
}

$conn->close();
?> 