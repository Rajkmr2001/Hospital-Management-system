<?php
// Include authentication check
include __DIR__ . '/php/auth_check.php';

// If we reach here, user is authenticated
// Read and output the dashboard.html file
$dashboard_file = __DIR__ . '/dashboard.html';

if (file_exists($dashboard_file)) {
    // Read the HTML file and output it
    $html_content = file_get_contents($dashboard_file);
    
    // Replace the static "Admin" text with the actual admin username from session
    $html_content = str_replace('Welcome back, Admin!', 'Welcome back, ' . htmlspecialchars($_SESSION['admin_username']) . '!', $html_content);
    $html_content = str_replace('<span>Admin</span>', '<span>' . htmlspecialchars($_SESSION['admin_username']) . '</span>', $html_content);
    
    // Add logout link to the profile dropdown
    $html_content = str_replace(
        '<a href="#">Logout</a>',
        '<a href="php/logout.php">Logout</a>',
        $html_content
    );
    
    echo $html_content;
} else {
    // Fallback if dashboard.html doesn't exist
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Dashboard Not Found</title>
    </head>
    <body>
        <h1>Dashboard file not found</h1>
        <p>The dashboard.html file is missing.</p>
        <a href="php/logout.php">Logout</a>
    </body>
    </html>';
}
?> 