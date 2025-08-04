<?php
session_start();

// Check if patient is logged in
if (!isset($_SESSION['patient_logged_in']) || $_SESSION['patient_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

header('Content-Type: application/json');

// Check if file was uploaded
if (!isset($_FILES['profile_picture']) || $_FILES['profile_picture']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
    exit();
}

$file = $_FILES['profile_picture'];
$patient_mobile = $_SESSION['patient_mobile'];

// Validate file type
$allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
if (!in_array($file['type'], $allowed_types)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed']);
    exit();
}

// Validate file size (5MB)
if ($file['size'] > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'File size must be less than 5MB']);
    exit();
}

// Create profile_pictures directory if it doesn't exist
$upload_dir = 'profile_pictures/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Generate filename using patient mobile number
$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = $patient_mobile . '.' . $file_extension;
$filepath = $upload_dir . $filename;

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    echo json_encode([
        'success' => true,
        'message' => 'Profile picture uploaded successfully',
        'picture_url' => $filepath
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save file']);
}
?> 