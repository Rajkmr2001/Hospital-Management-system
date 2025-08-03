<?php
// get_user_visits_stats.php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_management";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header('Content-Type: application/json');

// Delete user_visits older than 2 months
$conn->query("DELETE FROM user_visits WHERE visit_time < DATE_SUB(NOW(), INTERVAL 2 MONTH)");

// All visits per day
$all_visits = [];
$res = $conn->query("SELECT DATE(visit_time) as day, COUNT(*) as count FROM user_visits GROUP BY day ORDER BY day DESC");
while ($row = $res->fetch_assoc()) {
    $all_visits[] = $row;
}

// Unique IPs and their first visit time
$ips = [];
$res = $conn->query("SELECT user_ip, MIN(visit_time) as visit_time FROM user_visits GROUP BY user_ip ORDER BY visit_time DESC");
while ($row = $res->fetch_assoc()) {
    $ips[] = $row;
}

// Visits by hour for today
$visits_by_hour = [];
$res = $conn->query("SELECT DATE(visit_time) as day, HOUR(visit_time) as hour, COUNT(*) as count FROM user_visits WHERE DATE(visit_time) = CURDATE() GROUP BY day, hour");
while ($row = $res->fetch_assoc()) {
    $visits_by_hour[] = $row;
}

// Visits by day for current week
$week_visits = [];
$res = $conn->query("SELECT DAYNAME(visit_time) as weekday, COUNT(*) as count FROM user_visits WHERE YEARWEEK(visit_time, 1) = YEARWEEK(CURDATE(), 1) GROUP BY weekday");
while ($row = $res->fetch_assoc()) {
    $week_visits[] = $row;
}

// Visits by week for current month
$month_visits = [];
$res = $conn->query("SELECT WEEK(visit_time, 1) as week, COUNT(*) as count FROM user_visits WHERE MONTH(visit_time) = MONTH(CURDATE()) AND YEAR(visit_time) = YEAR(CURDATE()) GROUP BY week");
while ($row = $res->fetch_assoc()) {
    $month_visits[] = $row;
}

echo json_encode([
    'all_visits' => $all_visits,
    'ips' => $ips,
    'visits_by_hour' => $visits_by_hour,
    'week_visits' => $week_visits,
    'month_visits' => $month_visits
]);

$conn->close();
?> 