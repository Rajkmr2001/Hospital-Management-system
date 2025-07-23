<?php
// get_patient_data.php
include '../db/config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$sql = "SELECT * FROM patient_data ORDER BY id DESC";
$result = $conn->query($sql);

$patients = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($patients);

$conn->close();
?>
