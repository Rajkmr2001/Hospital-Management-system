<?php
include __DIR__ . '/../../../db/config.php';

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT COUNT(*) AS total FROM feedback";
$result = $conn->query($sql);

$total = 0;
if ($result && $row = $result->fetch_assoc()) {
    $total = (int)$row['total'];
}

echo json_encode(['total' => $total]);

$conn->close();
?>
