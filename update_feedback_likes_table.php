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

echo "Adding dislike_type column to feedback_likes table...\n";

// Add dislike_type column
$sql = "ALTER TABLE feedback_likes ADD COLUMN dislike_type ENUM('like', 'dislike') DEFAULT 'like' AFTER user_ip";
if ($conn->query($sql) === TRUE) {
    echo "Successfully added dislike_type column\n";
} else {
    echo "Error adding column: " . $conn->error . "\n";
}

// Update existing records
$sql = "UPDATE feedback_likes SET dislike_type = 'like' WHERE dislike_type IS NULL";
if ($conn->query($sql) === TRUE) {
    echo "Successfully updated existing records\n";
} else {
    echo "Error updating records: " . $conn->error . "\n";
}

// Verify the new structure
echo "\n=== Updated feedback_likes table structure ===\n";
$result = $conn->query("DESCRIBE feedback_likes");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
}

$conn->close();
?> 