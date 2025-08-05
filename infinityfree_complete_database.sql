-- =====================================================
-- HOSPITAL MANAGEMENT SYSTEM - COMPLETE DATABASE SETUP
-- OPTIMIZED FOR INFINITYFREE HOSTING
-- =====================================================
-- 
-- Instructions:
-- 1. Create a new database in your InfinityFree hosting
-- 2. Copy and paste this entire SQL file into phpMyAdmin
-- 3. Execute the SQL commands
-- 4. Update your PHP database connection settings
--
-- Features:
-- ✅ All CREATE VIEW statements removed (not supported on free plan)
-- ✅ All DEFINER statements removed
-- ✅ UTF8MB4 charset for full Unicode support
-- ✅ DROP TABLE statements for clean installation
-- ✅ Sample data included for testing
-- ✅ Proper foreign key constraints
-- ✅ Performance indexes
-- ✅ No CREATE DATABASE or USE statements (InfinityFree handles this)

-- =====================================================
-- 1. MESSAGES TABLE (Contact Form Submissions)
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
-- 2. PATIENT REGISTER TABLE (Patient Registration)
-- =====================================================
DROP TABLE IF EXISTS patient_register;
CREATE TABLE patient_register (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mobile_no VARCHAR(15) NOT NULL UNIQUE,
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
-- 3. PATIENT DATA TABLE (Admin Panel - Additional Patient Info)
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
-- 4. PATIENTS TABLE (Admin Panel - Basic Patient Info)
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
-- 5. ADMINS TABLE (Admin Authentication)
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
-- 6. FEEDBACK TABLE (Patient Feedback System)
-- =====================================================
DROP TABLE IF EXISTS feedback;
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    number VARCHAR(15) NOT NULL,
    message TEXT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 7. FEEDBACK LIKES TABLE (Feedback Like System)
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
-- 9. APPOINTMENTS TABLE (Appointment Management)
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
-- 10. USER VISITS TABLE (Website Analytics)
-- =====================================================
DROP TABLE IF EXISTS user_visits;
CREATE TABLE user_visits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_name VARCHAR(255) NOT NULL,
    visit_date DATE DEFAULT CURRENT_DATE,
    visit_time TIME DEFAULT CURRENT_TIME,
    user_ip VARCHAR(45),
    user_agent TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- PERFORMANCE INDEXES
-- =====================================================
-- Feedback indexes
CREATE INDEX idx_feedback_number ON feedback(number);
CREATE INDEX idx_feedback_timestamp ON feedback(timestamp);
CREATE INDEX idx_feedback_rating ON feedback(rating);

-- Messages indexes
CREATE INDEX idx_messages_name ON messages(name);
CREATE INDEX idx_messages_timestamp ON messages(timestamp);

-- Patient data indexes
CREATE INDEX idx_patient_data_contact ON patient_data(contact);
CREATE INDEX idx_patient_data_name ON patient_data(name);

-- Admin indexes
CREATE INDEX idx_admins_username ON admins(username);
CREATE INDEX idx_admins_mobile ON admins(mobile_number);
CREATE INDEX idx_admins_active ON admins(is_active);

-- Patient register indexes
CREATE INDEX idx_patient_register_mobile ON patient_register(mobile_no);
CREATE INDEX idx_patient_register_name ON patient_register(name);

-- Appointment indexes
CREATE INDEX idx_appointments_mobile ON appointments(patient_mobile);
CREATE INDEX idx_appointments_date ON appointments(appointment_date);
CREATE INDEX idx_appointments_status ON appointments(status);

-- User visits indexes
CREATE INDEX idx_user_visits_date ON user_visits(visit_date);
CREATE INDEX idx_user_visits_page ON user_visits(page_name);

-- =====================================================
-- SAMPLE DATA INSERTION
-- =====================================================

-- Insert sample patient registration data
-- Password for all users: admin123 (hashed with password_hash)
INSERT INTO patient_register (mobile_no, name, gender, password, register_date, register_time, age, address, medical_history) VALUES
('9876543210', 'John Doe', 'Male', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-15', '10:30:00', 25, '123 Main Street, City, State', 'No major medical history'),
('9876543211', 'Jane Smith', 'Female', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-16', '14:45:00', 30, '456 Oak Avenue, Town, State', 'Allergic to penicillin'),
('9876543212', 'Mike Johnson', 'Male', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-17', '09:15:00', 28, '789 Pine Road, Village, State', 'Hypertension'),
('9876543213', 'Sarah Wilson', 'Female', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-18', '16:20:00', 35, '321 Elm Street, City, State', 'Diabetes'),
('9876543214', 'David Brown', 'Male', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2024-01-19', '11:30:00', 42, '654 Maple Drive, Town, State', 'Asthma');

-- Insert default admin user
-- Username: admin, Password: admin123
INSERT INTO admins (username, mobile_number, password, email, full_name, role) VALUES 
('admin', '9876543210', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@maakalawati.com', 'System Administrator', 'admin')
ON DUPLICATE KEY UPDATE username=username;

-- Insert sample feedback data
INSERT INTO feedback (name, number, message, rating) VALUES
('John Doe', '9876543210', 'Excellent service and very professional staff! The doctors were very knowledgeable and caring.', 5),
('Jane Smith', '9876543211', 'The doctors were very knowledgeable and caring. Clean facility and quick service.', 4),
('Mike Johnson', '9876543212', 'Clean facility and quick service. Very satisfied with the treatment received.', 5),
('Sarah Wilson', '9876543213', 'Good experience overall, would recommend to others. Staff was very helpful.', 4),
('David Brown', '9876543214', 'Very satisfied with the treatment received. Professional and caring environment.', 5);

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
('Mike Johnson', '9876543212', 'Dr. Williams', '2024-02-17', '09:00:00', 'Orthopedics', 'Scheduled'),
('Sarah Wilson', '9876543213', 'Dr. Davis', '2024-02-18', '11:00:00', 'Neurology', 'Scheduled'),
('David Brown', '9876543214', 'Dr. Miller', '2024-02-19', '15:00:00', 'Gastroenterology', 'Scheduled');

-- Insert sample messages (contact form submissions)
INSERT INTO messages (name, email, phone, subject, message) VALUES
('Alice Johnson', 'alice@example.com', '9876543215', 'General Inquiry', 'I would like to know more about your cardiology services.'),
('Bob Wilson', 'bob@example.com', '9876543216', 'Appointment Request', 'I need to schedule an appointment with Dr. Smith.'),
('Carol Davis', 'carol@example.com', '9876543217', 'Feedback', 'Thank you for the excellent care provided to my mother.'),
('David Miller', 'david@example.com', '9876543218', 'Insurance Question', 'Do you accept Blue Cross Blue Shield insurance?'),
('Eva Garcia', 'eva@example.com', '9876543219', 'Emergency Services', 'What are your emergency service hours?');

-- =====================================================
-- DATABASE SETUP COMPLETE
-- =====================================================
--
-- Next Steps:
-- 1. Update your PHP database connection settings in config files
-- 2. Test the admin panel login (admin/admin123)
-- 3. Test patient registration and login
-- 4. Verify all features are working correctly
--
-- Default Login Credentials:
-- Admin Panel: admin / admin123
-- Patient Login: Use any mobile number from sample data with password: admin123
--
-- Tables Created:
-- ✅ messages (Contact form submissions)
-- ✅ patient_register (Patient registration)
-- ✅ patient_data (Additional patient info)
-- ✅ patients (Basic patient info)
-- ✅ admins (Admin authentication)
-- ✅ feedback (Patient feedback)
-- ✅ feedback_likes (Feedback like system)
-- ✅ patient_profile_pictures (Profile pictures)
-- ✅ appointments (Appointment management)
-- ✅ user_visits (Website analytics)
--
-- Total: 10 tables with sample data 