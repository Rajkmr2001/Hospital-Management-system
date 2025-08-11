<?php
// Unified analytics endpoint for admin User Visits UI
include __DIR__ . '/../db/config.php';
header('Content-Type: application/json');

function columnExists(mysqli $conn, string $table, string $column): bool {
    $tableEsc = $conn->real_escape_string($table);
    $columnEsc = $conn->real_escape_string($column);
    $sql = "SELECT 1 FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = '$tableEsc' AND column_name = '$columnEsc' LIMIT 1";
    $res = $conn->query($sql);
    $exists = $res && $res->num_rows > 0;
    if ($res) { $res->close(); }
    return $exists;
}

$ipCol = columnExists($conn, 'user_visits', 'user_ip') ? 'user_ip' : (columnExists($conn, 'user_visits', 'ip_address') ? 'ip_address' : 'user_ip');
$pageCol = columnExists($conn, 'user_visits', 'page_name') ? 'page_name' : (columnExists($conn, 'user_visits', 'page_visited') ? 'page_visited' : 'page_name');
// Prefer visit_datetime (DATETIME/TIMESTAMP) if available; fallback to visit_time only if needed
$tsCol = columnExists($conn, 'user_visits', 'visit_datetime') ? 'visit_datetime' : (columnExists($conn, 'user_visits', 'visit_time') ? 'visit_time' : 'visit_datetime');

// Auto-delete records older than 2 months
$conn->query("DELETE FROM user_visits WHERE `$tsCol` < DATE_SUB(NOW(), INTERVAL 2 MONTH)");

// Build optional exclusion list of IPs
$excludeIps = [];
if ($res = $conn->query("SHOW TABLES LIKE 'analytics_ip_exclusions'")) {
    if ($res->num_rows > 0) {
        if ($res2 = $conn->query("SELECT ip_address FROM analytics_ip_exclusions")) {
            while ($row = $res2->fetch_assoc()) { $excludeIps[] = $row['ip_address']; }
            $res2->close();
        }
    }
    $res->close();
}
$excludeCondition = '';
if (count($excludeIps) > 0) {
    $safeList = array_map(function($ip) use ($conn) { return "'" . $conn->real_escape_string($ip) . "'"; }, $excludeIps);
    $excludeCondition = " AND `$ipCol` NOT IN (" . implode(',', $safeList) . ")";
}

// Cards
// Card 1: total unique visitors for current month who visited index.html (distinct IPs once per month)
$sql_total_unique_index = "SELECT COUNT(DISTINCT `$ipCol`) AS cnt
                           FROM user_visits
                           WHERE YEAR(`$tsCol`) = YEAR(CURDATE())
                             AND MONTH(`$tsCol`) = MONTH(CURDATE())
                             AND ( `$pageCol` IN ('index.html','index.php','Home','/') OR `$pageCol` = '' )" . $excludeCondition;
$total_unique_current_month_index = 0;
if ($res = $conn->query($sql_total_unique_index)) {
    if ($row = $res->fetch_assoc()) { $total_unique_current_month_index = (int)$row['cnt']; }
    $res->close();
}

// Card 2: today's unique visitors (distinct IPs once)
$sql_today_unique = "SELECT COUNT(DISTINCT `$ipCol`) AS cnt FROM user_visits WHERE DATE(`$tsCol`) = CURDATE()" . $excludeCondition;
$today_unique = 0;
if ($res = $conn->query($sql_today_unique)) {
    if ($row = $res->fetch_assoc()) { $today_unique = (int)$row['cnt']; }
    $res->close();
}

// Card 3: this week's unique visitors (Sunday-based week)
$sql_week_unique = "SELECT COUNT(DISTINCT `$ipCol`) AS cnt FROM user_visits WHERE YEARWEEK(`$tsCol`, 0) = YEARWEEK(CURDATE(), 0)" . $excludeCondition;
$this_week_unique = 0;
if ($res = $conn->query($sql_week_unique)) {
    if ($row = $res->fetch_assoc()) { $this_week_unique = (int)$row['cnt']; }
    $res->close();
}

// Card 4: this month's unique visitors
$sql_month_unique = "SELECT COUNT(DISTINCT `$ipCol`) AS cnt FROM user_visits WHERE YEAR(`$tsCol`) = YEAR(CURDATE()) AND MONTH(`$tsCol`) = MONTH(CURDATE())" . $excludeCondition;
$this_month_unique = 0;
if ($res = $conn->query($sql_month_unique)) {
    if ($row = $res->fetch_assoc()) { $this_month_unique = (int)$row['cnt']; }
    $res->close();
}

// Daily unique for last 60 days
$daily = [];
$sql_daily = "SELECT DATE(`$tsCol`) AS day, COUNT(DISTINCT `$ipCol`) AS count
              FROM user_visits
              WHERE `$tsCol` >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)" . ($excludeCondition !== '' ? str_replace(' AND', ' AND', $excludeCondition) : '') . "
              GROUP BY day
              ORDER BY day ASC";
if ($res = $conn->query($sql_daily)) {
    while ($row = $res->fetch_assoc()) { $daily[] = $row; }
    $res->close();
}

// Daily total (including repeat visits) for last 60 days
$all_visits = [];
$sql_all = "SELECT DATE(`$tsCol`) AS day, COUNT(*) AS count
            FROM user_visits
            WHERE `$tsCol` >= DATE_SUB(CURDATE(), INTERVAL 60 DAY)" . ($excludeCondition !== '' ? str_replace(' AND', ' AND', $excludeCondition) : '') . "
            GROUP BY day
            ORDER BY day ASC";
if ($res = $conn->query($sql_all)) {
    while ($row = $res->fetch_assoc()) { $all_visits[] = $row; }
    $res->close();
}

// All unique IPs with their first visit timestamp
$ips = [];
$sql_ips = "SELECT `$ipCol` AS user_ip, MIN(`$tsCol`) AS first_visit
            FROM user_visits
            WHERE 1=1" . $excludeCondition . "
            GROUP BY `$ipCol`
            ORDER BY first_visit DESC";
if ($res = $conn->query($sql_ips)) {
    while ($row = $res->fetch_assoc()) { $ips[] = $row; }
    $res->close();
}

echo json_encode([
    'total_unique_current_month_index' => $total_unique_current_month_index,
    'today_unique' => $today_unique,
    'this_week_unique' => $this_week_unique,
    'this_month_unique' => $this_month_unique,
    'daily' => $daily,
    'all_visits' => $all_visits,
    'ips' => $ips,
]);

$conn->close();
?>