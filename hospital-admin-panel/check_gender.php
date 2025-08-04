<?php
include 'db/config.php';

$result = $conn->query("SHOW COLUMNS FROM patient_data LIKE 'gender'");
$row = $result->fetch_assoc();
echo "Gender column type: " . $row['Type'] . "\n";

$conn->close();
?> 