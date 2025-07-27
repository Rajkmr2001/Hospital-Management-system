-- Create admins table for hospital management system
CREATE TABLE IF NOT EXISTS admins (
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

-- Insert default admin user
-- Username: admin
-- Mobile Number: 9876543210
-- Password: admin123 (hashed with password_hash)
INSERT INTO admins (username, mobile_number, password, email, full_name, role) VALUES 
('admin', '9876543210', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@maakalawati.com', 'System Administrator', 'admin')
ON DUPLICATE KEY UPDATE username=username;

-- Create index for better performance
CREATE INDEX idx_admins_username ON admins(username);
CREATE INDEX idx_admins_mobile ON admins(mobile_number);
CREATE INDEX idx_admins_active ON admins(is_active); 