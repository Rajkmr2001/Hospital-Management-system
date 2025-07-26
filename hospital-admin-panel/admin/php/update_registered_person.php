<?php
include __DIR__ . '/../../../db/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $mobile_no = $_POST['mobile_no'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (!$id) {
        echo json_encode(['success' => false, 'message' => 'ID is required']);
        exit;
    }
    
                    if (empty($name) || empty($mobile_no) || empty($gender)) {
                    echo json_encode(['success' => false, 'message' => 'Name, mobile number, and gender are required']);
                    exit;
                }
                
                // Hash the password if provided, otherwise keep existing
                if (!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                } else {
                    // Get existing password using mobile_no as identifier
                    $get_sql = "SELECT password FROM patient_register WHERE mobile_no = ?";
                    $get_stmt = $conn->prepare($get_sql);
                    $get_stmt->bind_param("s", $id);
                    $get_stmt->execute();
                    $get_result = $get_stmt->get_result();
                    if ($get_row = $get_result->fetch_assoc()) {
                        $hashed_password = $get_row['password'];
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Person not found']);
                        exit;
                    }
                    $get_stmt->close();
                }
    
    try {
                            // Update the registered person using mobile_no as identifier
                    $sql = "UPDATE patient_register SET name = ?, mobile_no = ?, gender = ?, password = ? WHERE mobile_no = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $name, $mobile_no, $gender, $hashed_password, $id);
        
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true, 'message' => 'Registered person updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'No changes made or record not found']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update record']);
        }
        
        $stmt->close();
        
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

$conn->close();
?> 