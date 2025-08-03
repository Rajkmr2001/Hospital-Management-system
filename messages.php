<?php
// messages.php

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'hospital_management';
$port = 3306; // MySQL default port

$conn = new mysqli($host, $user, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch messages from database
$sql = "SELECT * FROM messages ORDER BY timestamp DESC";
$result = $conn->query($sql);
$messages = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Received Messages - Hospital Management</title>
<link href="style1.css" rel="stylesheet" />
</head>
<body>
<h1>Received Messages</h1>
<?php if (empty($messages)): ?>
<p>No messages received yet.</p>
<?php else: ?>
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Timestamp</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Message</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($messages as $msg): ?>
        <tr>
            <td><?= htmlspecialchars($msg['timestamp']) ?></td>
            <td><?= htmlspecialchars($msg['name']) ?></td>
            <td><?= htmlspecialchars($msg['email']) ?></td>
            <td><?= htmlspecialchars($msg['subject']) ?></td>
            <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
</body>
</html>
