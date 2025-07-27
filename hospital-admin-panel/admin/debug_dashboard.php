<?php
// Comprehensive debug script for dashboard_auth.php issues
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Dashboard Debug Information</h2>";

// 1. Check PHP version and configuration
echo "<h3>1. PHP Configuration</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Display Errors: " . (ini_get('display_errors') ? 'ON' : 'OFF') . "<br>";
echo "Error Reporting: " . error_reporting() . "<br>";

// 2. Check file paths and existence
echo "<h3>2. File Paths</h3>";
$current_dir = __DIR__;
echo "Current Directory: " . $current_dir . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

$files_to_check = [
    'dashboard_auth.php',
    'php/auth_check.php',
    'dashboard.html',
    'php/login.php',
    'php/logout.php'
];

foreach ($files_to_check as $file) {
    $full_path = $current_dir . '/' . $file;
    echo "$file: " . (file_exists($full_path) ? 'EXISTS' : 'MISSING') . " ($full_path)<br>";
    if (file_exists($full_path)) {
        echo "&nbsp;&nbsp;&nbsp;&nbsp;Readable: " . (is_readable($full_path) ? 'YES' : 'NO') . "<br>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;Size: " . filesize($full_path) . " bytes<br>";
    }
}

// 3. Test session functionality
echo "<h3>3. Session Test</h3>";
session_start();
echo "Session ID: " . session_id() . "<br>";
echo "Session Status: " . session_status() . "<br>";
echo "Session Data: <pre>" . print_r($_SESSION, true) . "</pre>";

// 4. Test auth_check.php inclusion
echo "<h3>4. Auth Check Test</h3>";
try {
    ob_start();
    include $current_dir . '/php/auth_check.php';
    $auth_output = ob_get_clean();
    echo "Auth check inclusion: SUCCESS<br>";
    if (!empty($auth_output)) {
        echo "Auth check output: " . htmlspecialchars($auth_output) . "<br>";
    }
} catch (Exception $e) {
    echo "Auth check inclusion: FAILED - " . $e->getMessage() . "<br>";
}

// 5. Test dashboard.html reading
echo "<h3>5. Dashboard HTML Test</h3>";
$dashboard_file = $current_dir . '/dashboard.html';
if (file_exists($dashboard_file)) {
    $content = file_get_contents($dashboard_file);
    if ($content !== false) {
        echo "Dashboard HTML reading: SUCCESS<br>";
        echo "Content length: " . strlen($content) . " characters<br>";
        echo "First 200 characters: " . htmlspecialchars(substr($content, 0, 200)) . "<br>";
    } else {
        echo "Dashboard HTML reading: FAILED - file_get_contents returned false<br>";
    }
} else {
    echo "Dashboard HTML reading: FAILED - file does not exist<br>";
}

// 6. Test the exact dashboard_auth.php logic
echo "<h3>6. Dashboard Auth Logic Test</h3>";
try {
    // Simulate the exact logic from dashboard_auth.php
    $dashboard_file = $current_dir . '/dashboard.html';
    
    if (file_exists($dashboard_file)) {
        $html_content = file_get_contents($dashboard_file);
        if ($html_content !== false) {
            echo "Dashboard auth logic: SUCCESS<br>";
            echo "HTML content loaded successfully<br>";
        } else {
            echo "Dashboard auth logic: FAILED - file_get_contents returned false<br>";
        }
    } else {
        echo "Dashboard auth logic: FAILED - dashboard.html not found<br>";
    }
} catch (Exception $e) {
    echo "Dashboard auth logic: FAILED - " . $e->getMessage() . "<br>";
}

// 7. Check Apache/PHP error logs location
echo "<h3>7. Error Log Information</h3>";
echo "PHP Error Log: " . ini_get('error_log') . "<br>";
echo "Apache Error Log (typical locations):<br>";
echo "- XAMPP: C:\\xampp\\apache\\logs\\error.log<br>";
echo "- XAMPP: C:\\xampp\\php\\logs\\php_error_log<br>";

echo "<h3>8. Next Steps</h3>";
echo "1. Try accessing: <a href='test_dashboard_access.php'>test_dashboard_access.php</a><br>";
echo "2. Try accessing: <a href='dashboard_auth_simple.php'>dashboard_auth_simple.php</a><br>";
echo "3. Check Apache error logs for specific error messages<br>";
echo "4. Try accessing dashboard_auth.php directly in browser<br>";
?> 