<?php
// Include database configuration
include '../../db/config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get patient details from the form
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $medical_history = $_POST['medical_history'];

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO patients (name, age, gender, contact, address, medical_history) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissss", $name, $age, $gender, $contact, $address, $medical_history);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New patient added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Patient</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h2>Add New Patient</h2>
        <form action="add_patient.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label for="contact">Contact Number:</label>
            <input type="text" id="contact" name="contact" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required></textarea>

            <label for="medical_history">Medical History:</label>
            <textarea id="medical_history" name="medical_history"></textarea>

            <button type="submit">Add Patient</button>
        </form>
        <a href="../manage_patients.html">Back to Manage Patients</a>
    </div>
</body>
</html>