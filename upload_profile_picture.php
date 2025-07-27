<?php
session_start();
include 'db/config.php';
header('Content-Type: application/json');

// Check if patient is logged in
if (!isset($_SESSION['patient_logged_in']) || $_SESSION['patient_logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit();
}

if (!isset($_FILES['profile_picture'])) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    exit();
}

$file = $_FILES['profile_picture'];
$patient_mobile = $_SESSION['patient_mobile'];

// Validate file type
$allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
if (!in_array($file['type'], $allowed_types)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.']);
    exit();
}

// Validate file size (5MB)
if ($file['size'] > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'message' => 'File size must be less than 5MB']);
    exit();
}

// Create profile_pictures directory if it doesn't exist
$upload_dir = 'profile_pictures';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Remove old profile picture if exists
$old_picture = $upload_dir . '/' . $patient_mobile . '.jpg';
if (file_exists($old_picture)) {
    unlink($old_picture);
}

// Generate new filename
$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$new_filename = $patient_mobile . '.jpg';
$upload_path = $upload_dir . '/' . $new_filename;

// Upload the file
if (move_uploaded_file($file['tmp_name'], $upload_path)) {
    // Convert to JPG if needed
    if ($file_extension !== 'jpg' && $file_extension !== 'jpeg') {
        $image = null;
        switch ($file_extension) {
            case 'png':
                $image = imagecreatefrompng($upload_path);
                break;
            case 'gif':
                $image = imagecreatefromgif($upload_path);
                break;
        }
        
        if ($image) {
            // Create a new image with white background
            $jpg_image = imagecreatetruecolor(imagesx($image), imagesy($image));
            $white = imagecolorallocate($jpg_image, 255, 255, 255);
            imagefill($jpg_image, 0, 0, $white);
            
            // Copy the original image onto the new one
            imagecopy($jpg_image, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            
            // Save as JPG
            imagejpeg($jpg_image, $upload_path, 90);
            
            // Clean up
            imagedestroy($image);
            imagedestroy($jpg_image);
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Profile picture uploaded successfully',
        'picture_url' => $upload_path
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
}

$conn->close();
?> 