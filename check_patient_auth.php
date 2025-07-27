<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['patient_logged_in']) && $_SESSION['patient_logged_in'] === true) {
    echo json_encode([
        'logged_in' => true,
        'name' => $_SESSION['patient_name'] ?? 'Patient',
        'mobile' => $_SESSION['patient_mobile'] ?? ''
    ]);
} else {
    echo json_encode([
        'logged_in' => false
    ]);
}
?> 