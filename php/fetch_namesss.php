<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
    $dbname = "hospital_management"; // Ensure this matches your actual database name
$port = 3306; // MySQL default port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the contact number from the AJAX request
if (isset($_POST['contact'])) {
    $contact = $_POST['contact'];

// Prepare and execute query safely
$stmt = $conn->prepare("SELECT name FROM patient_register WHERE mobile_no = ?");
$stmt->bind_param("s", $contact);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();

    if ($name) {
        echo $name; // Send name back to JavaScript
    } else {
        echo "not_found"; // Send "not_found" if no match
    }

    $stmt->close();
}

$conn->close();
?>
