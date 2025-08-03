<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_management"; // <-- Make sure this is correct
$port = 3306; // MySQL default port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>