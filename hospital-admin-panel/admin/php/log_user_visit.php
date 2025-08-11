<?php
include __DIR__ . '/../../../db/config.php';

$user_ip = $_SERVER['REMOTE_ADDR'];

// Determine page name from Referer header or explicit query param. Fallback to index.html
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$page_name = isset($_GET['page']) && $_GET['page'] !== '' ? $_GET['page'] : '';
if ($page_name === '') {
    $path = $referer ? parse_url($referer, PHP_URL_PATH) : '';
    $base = $path ? basename($path) : '';
    $page_name = $base !== '' ? $base : 'index.html';
}

// Skip logging if IP is in exclusion table (if present)
$skip = false;
if ($res = $conn->query("SHOW TABLES LIKE 'analytics_ip_exclusions'")) {
    if ($res->num_rows > 0) {
        $stmt = $conn->prepare("SELECT 1 FROM analytics_ip_exclusions WHERE ip_address = ? LIMIT 1");
        $stmt->bind_param("s", $user_ip);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) { $skip = true; }
        $stmt->close();
    }
    $res->close();
}
if ($skip) {
    $conn->close();
    exit;
}

// Resolve column names for IP
$ipCol = 'user_ip';
if ($res = $conn->query("SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'user_visits' AND column_name = 'user_ip' LIMIT 1")) {
    if ($res->num_rows === 0) { $ipCol = 'ip_address'; }
    $res->close();
}

// Check if this IP has already visited this page today
$today = date('Y-m-d');
$check_sql = "SELECT id FROM user_visits WHERE `$ipCol` = ? AND DATE(visit_time) = ? AND page_name = ? LIMIT 1";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("sss", $user_ip, $today, $page_name);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows === 0) {
    // First visit today for this IP on this page - insert new record
    $check_stmt->close();
    $insert_sql = "INSERT INTO user_visits (`$ipCol`, page_name, visit_time) VALUES (?, ?, NOW())";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ss", $user_ip, $page_name);
    $insert_stmt->execute();
    $insert_stmt->close();
} else {
    // Already visited today on this page - update visit_time to current time
    $check_stmt->close();
    $update_sql = "UPDATE user_visits SET visit_time = NOW() WHERE `$ipCol` = ? AND DATE(visit_time) = ? AND page_name = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sss", $user_ip, $today, $page_name);
    $update_stmt->execute();
    $update_stmt->close();
}

$conn->close();
?>