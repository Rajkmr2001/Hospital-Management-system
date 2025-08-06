<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db/config.php';

// Clean up old data (older than 2 months)
$conn->query("DELETE FROM user_visits WHERE visit_date < DATE_SUB(NOW(), INTERVAL 2 MONTH)");

$range = $_GET['range'] ?? 'week';
if ($range === 'week') {
    $start = date('Y-m-d', strtotime('monday this week'));
    $end = date('Y-m-d', strtotime('sunday this week'));
} else {
    $start = date('Y-m-d', strtotime('-2 months'));
    $end = date('Y-m-d');
}

// Get counts per day
$sql = "SELECT visit_date as day, COUNT(*) as count FROM user_visits WHERE visit_date BETWEEN '$start' AND '$end' GROUP BY day ORDER BY day ASC";
$res = $conn->query($sql);
$days = [];
while ($row = $res->fetch_assoc()) {
    $days[$row['day']] = (int)$row['count'];
}

// Fill missing days
$labels = [];
$counts = [];
$period = new DatePeriod(new DateTime($start), new DateInterval('P1D'), (new DateTime($end))->modify('+1 day'));
foreach ($period as $dt) {
    $d = $dt->format('Y-m-d');
    $labels[] = $dt->format('M d');
    $counts[] = $days[$d] ?? 0;
}

echo json_encode([
    'labels' => $labels,
    'counts' => $counts,
    'total_visits' => array_sum($counts)
]); 