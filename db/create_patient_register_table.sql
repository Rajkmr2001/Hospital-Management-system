-- Create patient_register table
CREATE TABLE IF NOT EXISTS patient_register (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mobile_no VARCHAR(15) NOT NULL,
    name VARCHAR(255) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    password VARCHAR(255) NOT NULL,
    register_date DATE DEFAULT CURRENT_DATE,
    register_time TIME DEFAULT CURRENT_TIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert some sample data for testing
INSERT INTO patient_register (mobile_no, name, gender, password, register_date, register_time) VALUES
('9876543210', 'John Doe', 'Male', 'password123', '2024-01-15', '10:30:00'),
('9876543211', 'Jane Smith', 'Female', 'password456', '2024-01-16', '14:45:00'),
('9876543212', 'Mike Johnson', 'Male', 'password789', '2024-01-17', '09:15:00'),
('9876543213', 'Sarah Wilson', 'Female', 'passwordabc', '2024-01-18', '16:20:00'),
('9876543214', 'David Brown', 'Male', 'passworddef', '2024-01-19', '11:30:00'); 