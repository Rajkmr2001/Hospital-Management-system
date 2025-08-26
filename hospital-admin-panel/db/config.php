<?php
// Database configuration for GoogieHost
$host = "localhost";
$db = "hospital_management";
$user = "hospit27__PZjn81Jvd6McFpdoV7B4JC04nuao4p2c";
$pass = "Rajftp620";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4 for proper Unicode support
$conn->set_charset("utf8mb4");
?>