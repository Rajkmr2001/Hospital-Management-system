<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_management";
$port = 3306; // MySQL default port

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Database connection failed.");
}

$name = $_POST['name'];
$mobile = $_POST['mobile'];
$gender = $_POST['gender'];
$password = $_POST['password'];

// Validate mobile number
if (!preg_match("/^\d{10}$/", $mobile)) {
    echo "Error: Mobile number must be exactly 10 digits.";
    exit();
}

// Validate password
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
    echo "Error: Password must be at least 8 characters with uppercase, lowercase, number, and special character.";
    exit();
}

// Check if mobile is already registered
$check_sql = "SELECT * FROM patient_register WHERE mobile_no = '$mobile'";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    echo "You have already registered!";
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Get current date and time
$register_date = date("Y-m-d");
$register_time = date("H:i:s A");

// Insert data with register_date and register_time
$sql = "INSERT INTO patient_register (mobile_no, name, gender, password, register_date, register_time) 
        VALUES ('$mobile', '$name', '$gender', '$hashed_password', '$register_date', '$register_time')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
} else {
    echo "Error: Could not register.";
}

$conn->close();
?>
