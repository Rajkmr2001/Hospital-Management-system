<?php
// Database credentials
$servername = "localhost";  // XAMPP MySQL host
$username = "root";         // Database username
$password = "";             // Database password
$dbname = "hospital_management";  // Your database name
$port = 3306; // MySQL default port

// Set the default timezone
date_default_timezone_set("Asia/Kolkata"); // Change to your desired timezone

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $submission_time = date("h:i A"); // Current time with AM/PM
    $submission_date = date("Y-m-d"); // Current date

    // Prepare SQL query to insert data into the database
    $sql = "INSERT INTO patient_data (contact, name, age, gender, address, submission_time, submission_date)
            VALUES ('$contact', '$name', '$age', '$gender', '$address', '$submission_time', '$submission_date')";

    // Execute query and check if data is inserted
    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully, redirect to the page to view data
        header("Location: show_pdata.php?contact=$contact");
        exit(); // Make sure to exit after header redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
