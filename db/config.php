<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_management"; // Use your actual database name
$port = 3307; // Add port number

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
