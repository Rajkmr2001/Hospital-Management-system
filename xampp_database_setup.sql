-- =====================================================
-- HOSPITAL MANAGEMENT SYSTEM - XAMPP LOCAL SETUP
-- =====================================================
-- 
-- Instructions:
-- 1. Open XAMPP Control Panel
-- 2. Start Apache and MySQL services
-- 3. Open phpMyAdmin (http://localhost/phpmyadmin)
-- 4. Create a new database named "hospital_management"
-- 5. Select the database and go to SQL tab
-- 6. Copy and paste this entire SQL file
-- 7. Click "Go" to execute
--
-- Features:
-- ✅ All tables for hospital management system
-- ✅ Sample data for testing
-- ✅ Proper indexes for performance
-- ✅ UTF8MB4 charset for Unicode support
-- ✅ Foreign key constraints

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
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 7. FEEDBACK LIKES TABLE (Feedback Like System)
-- =====================================================
DROP TABLE IF EXISTS feedback_likes;
CREATE TABLE feedback_likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    feedback_id INT NOT NULL,
    user_identifier VARCHAR(255) NOT NULL,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_like (feedback_id, user_identifier),
    FOREIGN KEY (feedback_id) REFERENCES feedback(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 8. PATIENT PROFILE PICTURES TABLE
-- =====================================================
DROP TABLE IF EXISTS patient_profile_pictures;
CREATE TABLE patient_profile_pictures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mobile_no VARCHAR(15) NOT NULL UNIQUE,
    picture_path VARCHAR(255) NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mobile_no) REFERENCES patient_register(mobile_no) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- 9. APPOINTMENTS TABLE
-- =====================================================
DROP TABLE IF EXISTS appointments;
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_mobile VARCHAR(15) NOT NULL,
    patient_name VARCHAR(255) NOT NULL,
    doctor_name VARCHAR(255) NOT NULL,
    department VARCHAR(255) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('Scheduled', 'Completed', 'Cancelled') DEFAULT 'Scheduled',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_mobile) REFERENCES patient_register(mobile_no) ON DELETE CASCADE
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
    visit_datetime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45),
    user_agent TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- CREATE INDEXES FOR PERFORMANCE
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
-- INSERT SAMPLE DATA
-- =====================================================

-- Insert sample admin (password: admin123)
INSERT INTO admins (username, mobile_number, password, email, full_name, role) VALUES
('admin', '9876543210', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@hospital.com', 'System Administrator', 'admin');

-- Insert sample patients
INSERT INTO patient_register (mobile_no, name, gender, password, age, address, medical_history) VALUES
('9873216540', 'John Doe', 'Male', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 35, '123 Main St, City', 'Hypertension'),
('9900786549', 'Jane Smith', 'Female', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 28, '456 Oak Ave, Town', 'Diabetes'),
('9911223344', 'Mike Johnson', 'Male', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 42, '789 Pine Rd, Village', 'Asthma');

-- Insert sample patient data
INSERT INTO patient_data (name, age, gender, contact, address, medical_history) VALUES
('John Doe', 35, 'Male', '9873216540', '123 Main St, City', 'Hypertension'),
('Jane Smith', 28, 'Female', '9900786549', '456 Oak Ave, Town', 'Diabetes'),
('Mike Johnson', 42, 'Male', '9911223344', '789 Pine Rd, Village', 'Asthma');

-- Insert sample messages
INSERT INTO messages (name, email, phone, subject, message) VALUES
('Alice Brown', 'alice@email.com', '9876543210', 'Appointment Inquiry', 'I would like to book an appointment with Dr. Smith.'),
('Bob Wilson', 'bob@email.com', '9876543211', 'General Inquiry', 'What are your operating hours?'),
('Carol Davis', 'carol@email.com', '9876543212', 'Emergency Contact', 'Need urgent medical consultation.');

-- Insert sample feedback
INSERT INTO feedback (name, number, rating, comment) VALUES
('John Doe', '9873216540', 5, 'Excellent service and care!'),
('Jane Smith', '9900786549', 4, 'Very professional staff.'),
('Mike Johnson', '9911223344', 5, 'Great experience overall.');

-- Insert sample appointments
INSERT INTO appointments (patient_mobile, patient_name, doctor_name, department, appointment_date, appointment_time) VALUES
('9873216540', 'John Doe', 'Dr. Smith', 'Cardiology', '2024-01-15', '10:00:00'),
('9900786549', 'Jane Smith', 'Dr. Johnson', 'Dermatology', '2024-01-16', '14:30:00'),
('9911223344', 'Mike Johnson', 'Dr. Williams', 'Neurology', '2024-01-17', '09:15:00');

-- Insert sample user visits
INSERT INTO user_visits (page_name, ip_address, user_agent) VALUES
('Home', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'),
('About Us', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'),
('Contact', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');

-- =====================================================
-- SETUP COMPLETE!
-- =====================================================
-- Your hospital management system database is now ready for XAMPP local development.
-- You can now run your PHP files with localhost in your browser. 