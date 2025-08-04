<?php
// Test script to verify add_patient.php functionality
include 'db/config.php';

echo "<h2>Testing Add Patient Functionality</h2>";

// Test database connection
if ($conn->connect_error) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
    exit;
} else {
    echo "<p style='color: green;'>✅ Database connection successful!</p>";
}

// Test inserting a sample patient
$test_name = "Test Patient";
$test_age = 30;
$test_gender = "Male";
$test_contact = "1234567890";
$test_address = "123 Test Street, Test City";

$stmt = $conn->prepare("INSERT INTO patient_data (contact, name, age, gender, address) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss", $test_contact, $test_name, $test_age, $test_gender, $test_address);

if ($stmt->execute()) {
    echo "<p style='color: green;'>✅ Test patient inserted successfully!</p>";
    echo "<p>Inserted ID: " . $conn->insert_id . "</p>";
    
    // Now let's retrieve the patient to verify
    $select_stmt = $conn->prepare("SELECT * FROM patient_data WHERE contact = ?");
    $select_stmt->bind_param("s", $test_contact);
    $select_stmt->execute();
    $result = $select_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        echo "<p style='color: green;'>✅ Patient retrieved successfully!</p>";
        echo "<p><strong>ID:</strong> " . $patient['id'] . "</p>";
        echo "<p><strong>Name:</strong> " . $patient['name'] . "</p>";
        echo "<p><strong>Age:</strong> " . $patient['age'] . "</p>";
        echo "<p><strong>Gender:</strong> " . $patient['gender'] . "</p>";
        echo "<p><strong>Contact:</strong> " . $patient['contact'] . "</p>";
        echo "<p><strong>Address:</strong> " . $patient['address'] . "</p>";
        
        // Clean up - delete the test patient
        $delete_stmt = $conn->prepare("DELETE FROM patient_data WHERE contact = ?");
        $delete_stmt->bind_param("s", $test_contact);
        if ($delete_stmt->execute()) {
            echo "<p style='color: green;'>✅ Test patient cleaned up successfully!</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Could not clean up test patient: " . $delete_stmt->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Could not retrieve test patient!</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Failed to insert test patient: " . $stmt->error . "</p>";
}

$conn->close();
echo "<p><strong>Test completed!</strong></p>";
?> 