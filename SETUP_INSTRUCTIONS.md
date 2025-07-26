# Setup Instructions for Registered Persons Management

## Database Setup

If the `patient_register` table doesn't exist in your database, please run the following SQL commands in phpMyAdmin:

**Note:** If you're getting "Unknown column 'id' in 'order clause'" errors, it means your table doesn't have an `id` column. The system has been updated to work with or without an `id` column by using `mobile_no` as the unique identifier.

```sql
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

-- Insert some sample data for testing (optional)
INSERT INTO patient_register (mobile_no, name, gender, password, register_date, register_time) VALUES
('9876543210', 'John Doe', 'Male', '$2y$10$example_hash_here', '2024-01-15', '10:30:00'),
('9876543211', 'Jane Smith', 'Female', '$2y$10$example_hash_here', '2024-01-16', '14:45:00');
```

## Testing

1. Open your browser and navigate to: `http://localhost/hospital_backend/hospital-admin-panel/admin/test.html`
2. Click "Test Database Connection" to verify the database connection
3. Click "Test Get Registered Persons" to see if data is being fetched correctly

## Troubleshooting

If you see errors:
1. Make sure XAMPP is running (Apache and MySQL)
2. Check that the database `hospital_management` exists
3. Verify the table `patient_register` exists with the correct structure
4. Check the browser console for any JavaScript errors

## Features

The Registered Persons management page includes:
- View all registered persons
- Edit person details (name, mobile, gender)
- Change passwords (optional)
- Delete persons
- Responsive design for mobile and desktop
- Custom confirmation dialogs 