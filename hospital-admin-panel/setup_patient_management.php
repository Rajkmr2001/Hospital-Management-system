<?php
// Setup script for Patient Management System
include 'db/config.php';

echo "<h1>Patient Management System Setup</h1>";

// Test database connection
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
    echo "<p>Please check your database configuration in db/config.php</p>";
    exit;
} else {
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
}

// Check if patient_data table exists
$table_check = $conn->query("SHOW TABLES LIKE 'patient_data'");
if ($table_check->num_rows > 0) {
    echo "<p style='color: green;'>✅ patient_data table already exists!</p>";
} else {
    echo "<p style='color: orange;'>⚠️ patient_data table does not exist. Creating it now...</p>";
    
    // Create the patient_data table
    $create_table_sql = "
    CREATE TABLE IF NOT EXISTS patient_data (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        age INT NOT NULL,
        gender VARCHAR(10) NOT NULL,
        contact VARCHAR(50) NOT NULL,
        address TEXT,
        medical_history TEXT,
        submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        submission_date DATE DEFAULT CURDATE()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    
    if ($conn->query($create_table_sql) === TRUE) {
        echo "<p style='color: green;'>✅ patient_data table created successfully!</p>";
        
        // Create index
        $index_sql = "CREATE INDEX IF NOT EXISTS idx_patient_data_contact ON patient_data(contact);";
        if ($conn->query($index_sql) === TRUE) {
            echo "<p style='color: green;'>✅ Index created successfully!</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Index creation failed: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Error creating table: " . $conn->error . "</p>";
    }
}

// Show table structure
echo "<h2>Current Table Structure:</h2>";
$structure = $conn->query("DESCRIBE patient_data");
if ($structure) {
    echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
    echo "<tr style='background-color: #f0f0f0;'><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($row = $structure->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Default']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Extra']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Count records
$count = $conn->query("SELECT COUNT(*) as total FROM patient_data");
if ($count) {
    $total = $count->fetch_assoc()['total'];
    echo "<p><strong>Total records in patient_data:</strong> " . $total . "</p>";
}

// Test the PHP files
echo "<h2>Testing PHP Files:</h2>";

// Test get_patients.php
echo "<h3>Testing get_patients.php:</h3>";
$test_url = "admin/php/get_patients.php";
if (file_exists($test_url)) {
    echo "<p style='color: green;'>✅ File exists</p>";
    // You can add more tests here if needed
} else {
    echo "<p style='color: red;'>❌ File not found</p>";
}

// Test add_patient.php
echo "<h3>Testing add_patient.php:</h3>";
$test_url = "admin/php/add_patient.php";
if (file_exists($test_url)) {
    echo "<p style='color: green;'>✅ File exists</p>";
} else {
    echo "<p style='color: red;'>❌ File not found</p>";
}

// Test update_patient.php
echo "<h3>Testing update_patient.php:</h3>";
$test_url = "admin/php/update_patient.php";
if (file_exists($test_url)) {
    echo "<p style='color: green;'>✅ File exists</p>";
} else {
    echo "<p style='color: red;'>❌ File not found</p>";
}

echo "<h2>Setup Complete!</h2>";
echo "<p>Your patient management system should now be working. You can:</p>";
echo "<ul>";
echo "<li><a href='admin/manage_patients.php' target='_blank'>Access the Patient Management Panel</a></li>";
echo "<li>Add new patients</li>";
echo "<li>Edit existing patients</li>";
echo "<li>Delete patients</li>";
echo "</ul>";

echo "<h3>If you still have issues:</h3>";
echo "<ol>";
echo "<li>Make sure your XAMPP Apache and MySQL services are running</li>";
echo "<li>Check that the database 'hospital_management' exists</li>";
echo "<li>Verify the database credentials in db/config.php</li>";
echo "<li>Check the browser console for JavaScript errors</li>";
echo "</ol>";

$conn->close();
?> 