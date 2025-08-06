<?php
include '../../db/config.php';
header('Content-Type: text/html; charset=utf-8');
$sql = "SHOW TABLES LIKE 'messages'";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    echo "<h2>messages table exists.</h2>";
    $sql2 = "SELECT * FROM messages ORDER BY id DESC LIMIT 10";
    $result2 = $conn->query($sql2);
    if ($result2 && $result2->num_rows > 0) {
        echo "<table border='1' cellpadding='6'><tr>";
        foreach ($result2->fetch_fields() as $field) {
            echo "<th>{$field->name}</th>";
        }
        echo "</tr>";
        $result2->data_seek(0);
        while ($row = $result2->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $val) {
                echo "<td>" . htmlspecialchars($val) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No messages found in the table.</p>";
    }
} else {
    echo "<h2>messages table does NOT exist.</h2>";
}
$conn->close();
?>
