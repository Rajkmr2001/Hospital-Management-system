-- SQL Commands for Patient Dashboard Database Setup
-- Run these commands in your MySQL database

-- 1. Add new columns to patient_register table (if not exists)
ALTER TABLE patient_register 
ADD COLUMN IF NOT EXISTS age INT DEFAULT NULL,
ADD COLUMN IF NOT EXISTS address TEXT DEFAULT NULL,
ADD COLUMN IF NOT EXISTS medical_history TEXT DEFAULT NULL;

-- 2. Create profile_pictures directory reference table (if not exists)
CREATE TABLE IF NOT EXISTS patient_profile_pictures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_mobile VARCHAR(15) NOT NULL UNIQUE,
    picture_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_mobile) REFERENCES patient_register(mobile_no) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Insert sample data for testing (optional)
-- Update existing patient_register records with additional info
UPDATE patient_register SET 
    age = 25,
    address = '123 Main Street, City, State',
    medical_history = 'No major medical history'
WHERE mobile_no = '9876543210';

UPDATE patient_register SET 
    age = 30,
    address = '456 Oak Avenue, Town, State',
    medical_history = 'Allergic to penicillin'
WHERE mobile_no = '9876543211';

-- 4. Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_feedback_number ON feedback(number);
CREATE INDEX IF NOT EXISTS idx_messages_name ON messages(name);
CREATE INDEX IF NOT EXISTS idx_patient_data_contact ON patient_data(contact);

-- 5. Ensure proper foreign key constraints
-- Note: This assumes your existing tables have proper structure
-- If you get errors, you may need to adjust the foreign key relationships

-- 6. Create a view for patient dashboard data (optional)
CREATE OR REPLACE VIEW patient_dashboard_view AS
SELECT 
    pr.mobile_no,
    pr.name,
    pr.gender,
    pr.register_date,
    pr.register_time,
    pd.age,
    pd.address,
    pd.medical_history,
    COUNT(DISTINCT f.id) as total_feedback,
    COUNT(DISTINCT m.id) as total_messages
FROM patient_register pr
LEFT JOIN patient_data pd ON pr.mobile_no = pd.contact
LEFT JOIN feedback f ON pr.mobile_no = f.number
LEFT JOIN messages m ON pr.name = m.name
GROUP BY pr.mobile_no, pr.name, pr.gender, pr.register_date, pr.register_time, pd.age, pd.address, pd.medical_history; 