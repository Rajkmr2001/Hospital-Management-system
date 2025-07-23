<?php
include '../../db/config.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM patient_data";
$result = $conn->query($sql);

$patients = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

echo json_encode($patients);

$conn->close();
?>