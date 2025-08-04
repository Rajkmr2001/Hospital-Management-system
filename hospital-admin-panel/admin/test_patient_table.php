<?php
// Test script to check patient_data table and database connection
include '../db/config.php';

echo "<h2>Database Connection Test</h2>";

// Test database connection
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
    exit;
} else {
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
}

// Check if patient_data table exists
$table_check = $conn->query("SHOW TABLES LIKE 'patient_data'");
if ($table_check->num_rows > 0) {
    echo "<p style='color: green;'>✅ patient_data table exists!</p>";
    
    // Show table structure
    $structure = $conn->query("DESCRIBE patient_data");
    echo "<h3>Table Structure:</h3>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $structure->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Count records
    $count = $conn->query("SELECT COUNT(*) as total FROM patient_data");
    $total = $count->fetch_assoc()['total'];
    echo "<p><strong>Total records in patient_data:</strong> " . $total . "</p>";
    
} else {
    echo "<p style='color: red;'>❌ patient_data table does not exist!</p>";
    echo "<p>You need to run the SQL script to create the table.</p>";
}

// Show all tables in database
echo "<h3>All tables in database:</h3>";
$tables = $conn->query("SHOW TABLES");
echo "<ul>";
while ($table = $tables->fetch_array()) {
    echo "<li>" . $table[0] . "</li>";
}
echo "</ul>";

$conn->close();
?> 