-- Create patient_data table for admin panel
CREATE TABLE IF NOT EXISTS patient_data (
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

-- Create index on contact for better performance
CREATE INDEX IF NOT EXISTS idx_patient_data_contact ON patient_data(contact); 