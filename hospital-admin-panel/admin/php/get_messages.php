<?php
include '../../db/config.php';
header('Content-Type: application/json');
$sql = "SELECT * FROM messages ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);
$messages = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}
echo json_encode($messages);
$conn->close();
?>
