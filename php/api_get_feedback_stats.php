<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db/config.php';

// Clean up old data (older than 2 months)
$conn->query("DELETE FROM feedback WHERE timestamp < DATE_SUB(NOW(), INTERVAL 2 MONTH)");

$range = $_GET['range'] ?? 'week';
if ($range === 'week') {
    $start = date('Y-m-d', strtotime('monday this week'));
    $end = date('Y-m-d', strtotime('sunday this week'));
} else {
    $start = date('Y-m-d', strtotime('-2 months'));
    $end = date('Y-m-d');
}

// Get counts per day
$sql = "SELECT DATE(timestamp) as day, COUNT(*) as count FROM feedback WHERE timestamp BETWEEN '$start 00:00:00' AND '$end 23:59:59' GROUP BY day ORDER BY day ASC";
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
    'total_feedback' => array_sum($counts)
]); 