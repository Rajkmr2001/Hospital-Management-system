<?php
// Test script to verify contact form functionality with phone number
include 'db/config.php';

echo "<h2>Contact Form Test</h2>";

// Check if phone column exists in messages table
$result = $conn->query("DESCRIBE messages");
$columns = [];
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}

echo "<h3>Messages Table Structure:</h3>";
echo "<ul>";
foreach ($columns as $column) {
    echo "<li><strong>$column</strong></li>";
}
echo "</ul>";

if (in_array('phone', $columns)) {
    echo "<p style='color: green;'>✅ Phone column exists in messages table!</p>";
} else {
    echo "<p style='color: red;'>❌ Phone column missing. Please run the SQL script to add it.</p>";
    echo "<p>Run this SQL command in phpMyAdmin:</p>";
    echo "<code>ALTER TABLE messages ADD COLUMN phone VARCHAR(15) AFTER email;</code>";
}

echo "<hr>";
echo "<h3>Recent Messages (Last 5):</h3>";

$messages = $conn->query("SELECT * FROM messages ORDER BY timestamp DESC LIMIT 5");
if ($messages->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Subject</th><th>Message</th><th>Timestamp</th></tr>";
    while ($row = $messages->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['phone'] ?? 'N/A') . "</td>";
        echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
        echo "<td>" . htmlspecialchars(substr($row['message'], 0, 50)) . "...</td>";
        echo "<td>" . $row['timestamp'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No messages found in database.</p>";
}

echo "<hr>";
echo "<h3>How to Test Contact Form:</h3>";
echo "<ol>";
echo "<li>Go to <a href='contact.html'>contact.html</a></li>";
echo "<li>Fill out the form including the new phone number field</li>";
echo "<li>Submit the form</li>";
echo "<li>Check that the message appears in the admin panel</li>";
echo "<li>Verify the phone number is stored and displayed correctly</li>";
echo "</ol>";

$conn->close();
?> 