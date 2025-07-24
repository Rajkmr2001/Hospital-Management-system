<?php
include __DIR__ . '/../../../db/config.php';
header('Content-Type: application/json');

// Auto-delete records older than 2 months
$delete_sql = "DELETE FROM user_visits WHERE visit_time < DATE_SUB(NOW(), INTERVAL 2 MONTH)";
$conn->query($delete_sql);

// Get daily stats for last 60 days (unique)
$daily_sql = "SELECT DATE(visit_time) as day, COUNT(DISTINCT user_ip) as count FROM user_visits WHERE visit_time >= DATE_SUB(NOW(), INTERVAL 60 DAY) GROUP BY day ORDER BY day ASC";
$daily_result = $conn->query($daily_sql);
$daily = [];
while ($row = $daily_result->fetch_assoc()) {
    $daily[] = $row;
}

// Get daily stats for last 60 days (not unique)
$all_visits_sql = "SELECT DATE(visit_time) as day, COUNT(*) as count FROM user_visits WHERE visit_time >= DATE_SUB(NOW(), INTERVAL 60 DAY) GROUP BY day ORDER BY day ASC";
$all_visits_result = $conn->query($all_visits_sql);
$all_visits = [];
while ($row = $all_visits_result->fetch_assoc()) {
    $all_visits[] = $row;
}

// Get weekly stats for last 12 weeks (unique)
$weekly_sql = "SELECT YEAR(visit_time) as year, WEEK(visit_time, 1) as week, COUNT(DISTINCT user_ip) as count FROM user_visits WHERE visit_time >= DATE_SUB(NOW(), INTERVAL 12 WEEK) GROUP BY year, week ORDER BY year, week ASC";
$weekly_result = $conn->query($weekly_sql);
$weekly = [];
while ($row = $weekly_result->fetch_assoc()) {
    $weekly[] = $row;
}

// Get monthly stats for last 6 months (unique)
$monthly_sql = "SELECT YEAR(visit_time) as year, MONTH(visit_time) as month, COUNT(DISTINCT user_ip) as count FROM user_visits WHERE visit_time >= DATE_SUB(NOW(), INTERVAL 6 MONTH) GROUP BY year, month ORDER BY year, month ASC";
$monthly_result = $conn->query($monthly_sql);
$monthly = [];
while ($row = $monthly_result->fetch_assoc()) {
    $monthly[] = $row;
}

// Get all unique IPs with their first visit date
$ips_sql = "SELECT user_ip, MIN(visit_time) as first_visit FROM user_visits GROUP BY user_ip ORDER BY first_visit DESC";
$ips_result = $conn->query($ips_sql);
$ips = [];
while ($row = $ips_result->fetch_assoc()) {
    $ips[] = $row;
}

$conn->close();
echo json_encode([
    'daily' => $daily,
    'all_visits' => $all_visits,
    'weekly' => $weekly,
    'monthly' => $monthly,
    'ips' => $ips
]);
?> 