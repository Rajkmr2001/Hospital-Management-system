<?php
// get_appointments.php
include '../../db/config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Assuming appointments are stored in a table named 'appointments'
$sql = "SELECT * FROM appointments ORDER BY id DESC";
$result = $conn->query($sql);

$appointments = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($appointments);

$conn->close();
?>
