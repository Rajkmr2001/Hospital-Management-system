<?php
// Debug script to check specific user
include 'db/config.php';

$test_mobile = "9873216540";
$test_password = "Find@9873";

echo "<h2>Debug User Check</h2>";
echo "<p>Checking for mobile: <strong>$test_mobile</strong></p>";
echo "<p>Testing password: <strong>$test_password</strong></p>";

// Check if user exists
$stmt = $conn->prepare("SELECT * FROM patient_register WHERE mobile_no = ?");
$stmt->bind_param("s", $test_mobile);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "<p style='color: green;'>✅ User found!</p>";
    echo "<p><strong>Name:</strong> " . $user['name'] . "</p>";
    echo "<p><strong>Mobile:</strong> " . $user['mobile_no'] . "</p>";
    echo "<p><strong>Gender:</strong> " . $user['gender'] . "</p>";
    echo "<p><strong>ID:</strong> " . ($user['id'] ?? 'NULL') . "</p>";
    echo "<p><strong>Password Hash:</strong> " . substr($user['password'], 0, 30) . "...</p>";
    echo "<p><strong>Register Date:</strong> " . $user['register_date'] . "</p>";
    
    // Test password verification
    echo "<hr>";
    echo "<h3>Password Verification Test</h3>";
    
    if (password_verify($test_password, $user['password'])) {
        echo "<p style='color: green;'>✅ Password verification successful!</p>";
        echo "<p>This means the login should work.</p>";
    } else {
        echo "<p style='color: red;'>❌ Password verification failed!</p>";
        echo "<p>This means either:</p>";
        echo "<ul>";
        echo "<li>The password you entered is incorrect</li>";
        echo "<li>The password was not hashed properly during registration</li>";
        echo "</ul>";
        
        // Let's also test with the raw password from database (in case it's not hashed)
        if ($user['password'] === $test_password) {
            echo "<p style='color: orange;'>⚠️ Password matches as plain text (not hashed)</p>";
        }
    }
    
} else {
    echo "<p style='color: red;'>❌ User not found with mobile: $test_mobile</p>";
    echo "<p>This means the user is not registered in the database.</p>";
}

$stmt->close();

echo "<hr>";
echo "<h3>All Registered Users</h3>";
echo "<p>Here are all users in the database:</p>";

$all_users = $conn->query("SELECT mobile_no, name, gender, register_date FROM patient_register ORDER BY register_date DESC");
if ($all_users->num_rows > 0) {
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>Mobile</th><th>Name</th><th>Gender</th><th>Register Date</th></tr>";
    while ($row = $all_users->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['mobile_no'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['gender'] . "</td>";
        echo "<td>" . $row['register_date'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No users found in database.</p>";
}

$conn->close();
?> 