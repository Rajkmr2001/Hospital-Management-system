<?php
session_start();
include '../../db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $admin['password'])) {
            // Password is correct, set session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: ../dashboard.html");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No admin found with that username.";
    }

    $stmt->close();
}
$conn->close();
?>