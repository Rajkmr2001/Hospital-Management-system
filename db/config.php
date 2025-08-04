<?php
// Database configuration for InfinityFree hosting
$host = "sql306.infinityfree.com"; // InfinityFree MySQL host
$db = "if0_39629043_hospital_management";
$user = "if0_39629043";
$pass = "715020Rajkmr"; 

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4 for proper Unicode support
$conn->set_charset("utf8mb4");
?>
