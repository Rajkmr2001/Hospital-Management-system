<?php
// track_patient.php

// Include database configuration
include '../../db/config.php';

// Start session
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit();
}

// Function to get patient details
function getPatientDetails($patientId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM patients WHERE id = ?");
    $stmt->bind_param("i", $patientId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Check if patient ID is provided
if (isset($_GET['patient_id'])) {
    $patientId = intval($_GET['patient_id']);
    $patientDetails = getPatientDetails($patientId);
} else {
    $patientDetails = null;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Patient</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Track Patient Information</h1>
        <?php if ($patientDetails): ?>
            <h2>Patient ID: <?php echo htmlspecialchars($patientDetails['id']); ?></h2>
            <p>Name: <?php echo htmlspecialchars($patientDetails['name']); ?></p>
            <p>Age: <?php echo htmlspecialchars($patientDetails['age']); ?></p>
            <p>Gender: <?php echo htmlspecialchars($patientDetails['gender']); ?></p>
            <p>Medical History: <?php echo htmlspecialchars($patientDetails['medical_history']); ?></p>
            <p>Appointments: <?php echo htmlspecialchars($patientDetails['appointments']); ?></p>
        <?php else: ?>
            <p>No patient found with the provided ID.</p>
        <?php endif; ?>
        <a href="manage_patients.php">Back to Manage Patients</a>
    </div>
</body>
</html>