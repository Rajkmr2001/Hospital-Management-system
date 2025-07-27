<?php
// Password reset utility for testing
include 'db/config.php';

// WARNING: This is for testing only. Remove this file in production!

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = $_POST['mobile'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    
    if ($mobile && $new_password) {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        
        // Update the password
        $stmt = $conn->prepare("UPDATE patient_register SET password = ? WHERE mobile_no = ?");
        $stmt->bind_param("ss", $hashed_password, $mobile);
        
        if ($stmt->execute()) {
            echo "<p style='color: green;'>✅ Password updated successfully!</p>";
            echo "<p>Mobile: $mobile</p>";
            echo "<p>New Password: $new_password</p>";
        } else {
            echo "<p style='color: red;'>❌ Error updating password: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
}

// Get all registered users
$result = $conn->query("SELECT mobile_no, name FROM patient_register ORDER BY register_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Utility</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .warning { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { padding: 8px; border: 1px solid #ddd; border-radius: 4px; width: 200px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="warning">
        <strong>⚠️ WARNING:</strong> This utility is for testing purposes only. 
        Remove this file from your server in production!
    </div>

    <h2>Reset Test Password</h2>
    
    <form method="POST">
        <div class="form-group">
            <label for="mobile">Select Mobile Number:</label>
            <select name="mobile" id="mobile" required>
                <option value="">Choose a mobile number...</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['mobile_no']); ?>">
                        <?php echo htmlspecialchars($row['mobile_no']); ?> - <?php echo htmlspecialchars($row['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="new_password">New Password:</label>
            <input type="text" name="new_password" id="new_password" value="test123" required>
        </div>
        
        <button type="submit">Reset Password</button>
    </form>

    <h3>Registered Users</h3>
    <table>
        <thead>
            <tr>
                <th>Mobile</th>
                <th>Name</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $result->data_seek(0); // Reset result pointer
            while ($row = $result->fetch_assoc()): 
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['mobile_no']); ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['register_date'] ?? 'N/A'); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <hr>
    <p><strong>Instructions:</strong></p>
    <ol>
        <li>Select a mobile number from the dropdown</li>
        <li>Enter a new password (default: test123)</li>
        <li>Click "Reset Password"</li>
        <li>Try logging in with the mobile number and new password</li>
        <li>Delete this file after testing!</li>
    </ol>
</body>
</html>

<?php $conn->close(); ?> 