-- Hospital Management System Database Setup
-- CLEANED VERSION FOR INFINITYFREE HOSTING
-- All CREATE VIEW and DEFINER statements removed
-- All tables use utf8mb4 charset
-- DROP TABLE statements added for clean installation

-- =====================================================
-- 1. MESSAGES TABLE
-- =====================================================
DROP TABLE IF EXISTS messages;
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 2. PATIENT REGISTER TABLE
-- =====================================================
DROP TABLE IF EXISTS patient_register;
CREATE TABLE patient_register (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mobile_no VARCHAR(15) NOT NULL,
    name VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    password VARCHAR(255) NOT NULL,
    register_date DATE DEFAULT CURRENT_DATE,
    register_time TIME DEFAULT CURRENT_TIME,
    age INT DEFAULT NULL,
    address TEXT DEFAULT NULL,
    medical_history TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 3. PATIENT DATA TABLE (Admin Panel)
-- =====================================================
DROP TABLE IF EXISTS patient_data;
CREATE TABLE patient_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender VARCHAR(10) NOT NULL,
    contact VARCHAR(50) NOT NULL,
    address TEXT,
    medical_history TEXT,
    submission_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    submission_date DATE DEFAULT CURDATE()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 4. PATIENTS TABLE (Admin Panel)
-- =====================================================
DROP TABLE IF EXISTS patients;
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    gender VARCHAR(10) NOT NULL,
    contact VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 5. ADMINS TABLE
-- =====================================================
DROP TABLE IF EXISTS admins;
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    mobile_number VARCHAR(15) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100),
    role VARCHAR(50) DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 6. FEEDBACK TABLE
-- =====================================================
DROP TABLE IF EXISTS feedback;
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    number VARCHAR(15) NOT NULL,
    message TEXT NOT NULL,
    rating INT NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 7. FEEDBACK LIKES TABLE
-- =====================================================
DROP TABLE IF EXISTS feedback_likes;
CREATE TABLE feedback_likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    feedback_id INT NOT NULL,
    user_mobile VARCHAR(15) NOT NULL,
    liked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (feedback_id) REFERENCES feedback(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 8. PATIENT PROFILE PICTURES TABLE
-- =====================================================
DROP TABLE IF EXISTS patient_profile_pictures;
CREATE TABLE patient_profile_pictures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_mobile VARCHAR(15) NOT NULL UNIQUE,
    picture_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_mobile) REFERENCES patient_register(mobile_no) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 9. APPOINTMENTS TABLE
-- =====================================================
DROP TABLE IF EXISTS appointments;
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(255) NOT NULL,
    patient_mobile VARCHAR(15) NOT NULL,
    doctor_name VARCHAR(255) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    department VARCHAR(100) NOT NULL,
    status ENUM('Scheduled', 'Completed', 'Cancelled') DEFAULT 'Scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 10. USER VISITS TABLE
-- =====================================================
DROP TABLE IF EXISTS user_visits;
CREATE TABLE user_visits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_name VARCHAR(255) NOT NULL,
    visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    user_agent TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- INDEXES FOR BETTER PERFORMANCE
-- =====================================================
CREATE INDEX idx_feedback_number ON feedback(number);
CREATE INDEX idx_messages_name ON messages(name);
CREATE INDEX idx_patient_data_contact ON patient_data(contact);
CREATE INDEX idx_admins_username ON admins(username);
CREATE INDEX idx_admins_mobile ON admins(mobile_number);
CREATE INDEX idx_admins_active ON admins(is_active);
CREATE INDEX idx_patient_register_mobile ON patient_register(mobile_no);
CREATE INDEX idx_appointments_mobile ON appointments(patient_mobile);
CREATE INDEX idx_appointments_date ON appointments(appointment_date);

-- =====================================================
-- SAMPLE DATA INSERTION
-- =====================================================

-- Insert sample patient registration data
INSERT INTO patient_register (mobile_no, name, gender, password, register_date, register_time, age, address, medical_history) VALUES
('9876543210', 'John Doe', 'Male', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-15', '10:30:00', 25, '123 Main Street, City, State', 'No major medical history'),
('9876543211', 'Jane Smith', 'Female', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-16', '14:45:00', 30, '456 Oak Avenue, Town, State', 'Allergic to penicillin'),
('9876543212', 'Mike Johnson', 'Male', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-17', '09:15:00', 28, '789 Pine Road, Village, State', 'Hypertension'),
('9876543213', 'Sarah Wilson', 'Female', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-18', '16:20:00', 35, '321 Elm Street, City, State', 'Diabetes'),
('9876543214', 'David Brown', 'Male', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-19', '11:30:00', 42, '654 Maple Drive, Town, State', 'Asthma');

-- Insert default admin user
INSERT INTO admins (username, mobile_number, password, email, full_name, role) VALUES 
('admin', '9876543210', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@maakalawati.com', 'System Administrator', 'admin')
ON DUPLICATE KEY UPDATE username=username;

-- Insert sample feedback data
INSERT INTO feedback (name, number, message, rating) VALUES
('John Doe', '9876543210', 'Excellent service and very professional staff!', 5),
('Jane Smith', '9876543211', 'The doctors were very knowledgeable and caring.', 4),
('Mike Johnson', '9876543212', 'Clean facility and quick service.', 5),
('Sarah Wilson', '9876543213', 'Good experience overall, would recommend.', 4),
('David Brown', '9876543214', 'Very satisfied with the treatment received.', 5);

-- Insert sample patient data for admin panel
INSERT INTO patient_data (name, age, gender, contact, address, medical_history) VALUES
('John Doe', 25, 'Male', '9876543210', '123 Main Street, City, State', 'No major medical history'),
('Jane Smith', 30, 'Female', '9876543211', '456 Oak Avenue, Town, State', 'Allergic to penicillin'),
('Mike Johnson', 28, 'Male', '9876543212', '789 Pine Road, Village, State', 'Hypertension'),
('Sarah Wilson', 35, 'Female', '9876543213', '321 Elm Street, City, State', 'Diabetes'),
('David Brown', 42, 'Male', '9876543214', '654 Maple Drive, Town, State', 'Asthma');

-- Insert sample appointments
INSERT INTO appointments (patient_name, patient_mobile, doctor_name, appointment_date, appointment_time, department, status) VALUES
('John Doe', '9876543210', 'Dr. Smith', '2024-02-15', '10:00:00', 'Cardiology', 'Scheduled'),
('Jane Smith', '9876543211', 'Dr. Johnson', '2024-02-16', '14:30:00', 'Dermatology', 'Scheduled'),
('Mike Johnson', '9876543212', 'Dr. Williams', '2024-02-17', '09:00:00', 'Orthopedics', 'Scheduled');

-- =====================================================
-- NOTES FOR INFINITYFREE HOSTING
-- =====================================================
-- 1. All CREATE VIEW statements have been removed (not supported on free plan)
-- 2. All DEFINER statements have been removed
-- 3. All tables use utf8mb4 charset for full Unicode support
-- 4. DROP TABLE statements ensure clean installation
-- 5. No CREATE DATABASE or USE statements included
-- 6. Sample data included for testing
-- 7. All foreign key constraints properly defined
-- 8. Indexes created for optimal performance 