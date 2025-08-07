<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_username'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login.php");
    exit();
}

// Simple session-based authentication - no database check for now
// This ensures the dashboard works even if there are database issues
?> 