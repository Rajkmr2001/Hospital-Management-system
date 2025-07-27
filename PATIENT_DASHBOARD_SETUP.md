# Patient Dashboard Setup Guide

## Overview
This system provides a comprehensive patient dashboard where registered patients can view their information, feedback, messages, and manage their profile pictures.

## Features
- ✅ Patient authentication with mobile number and password
- ✅ Password visibility toggle (eye icon)
- ✅ Responsive design for all devices
- ✅ Custom dialog boxes for messages
- ✅ Profile picture upload (JPG, JPEG, PNG, GIF, max 5MB)
- ✅ Display patient information (Name, Age, Gender, Contact, Address, Medical History)
- ✅ Show feedback history (if any, otherwise shows NULL)
- ✅ Show message history (if any, otherwise shows NULL)
- ✅ Registration date and activity statistics
- ✅ Secure session management

## Files Created/Modified

### Frontend Files
1. `patient_login.html` - Updated with password toggle and AJAX login
2. `patient_dashboard.html` - New comprehensive dashboard page
3. `patient_dashboard.js` - JavaScript functionality for dashboard

### Backend Files
1. `patient_login.php` - Patient authentication
2. `check_patient_auth.php` - Session verification
3. `get_patient_dashboard_data.php` - Fetch all patient data
4. `upload_profile_picture.php` - Handle profile picture uploads
5. `patient_logout.php` - Logout functionality

### Database Files
1. `database_setup.sql` - SQL commands for database setup

## Setup Instructions

### 1. Database Setup
Run the SQL commands in `database_setup.sql` in your MySQL database:

```sql
-- Add new columns to patient_register table
ALTER TABLE patient_register 
ADD COLUMN IF NOT EXISTS age INT DEFAULT NULL,
ADD COLUMN IF NOT EXISTS address TEXT DEFAULT NULL,
ADD COLUMN IF NOT EXISTS medical_history TEXT DEFAULT NULL;

-- Create profile_pictures table
CREATE TABLE IF NOT EXISTS patient_profile_pictures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_mobile VARCHAR(15) NOT NULL UNIQUE,
    picture_path VARCHAR(255) NOT NULL,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_mobile) REFERENCES patient_register(mobile_no) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_feedback_number ON feedback(number);
CREATE INDEX IF NOT EXISTS idx_messages_name ON messages(name);
CREATE INDEX IF NOT EXISTS idx_patient_data_contact ON patient_data(contact);
```

### 2. Directory Setup
Create a `profile_pictures` directory in your project root:
```bash
mkdir profile_pictures
chmod 755 profile_pictures
```

### 3. Default Avatar
Replace `Images/default-avatar.png` with an actual 120x120 pixel PNG image for the default avatar.

### 4. File Permissions
Ensure your web server has write permissions to the `profile_pictures` directory.

## Usage Flow

### Patient Login
1. Patient visits `patient_login.html`
2. Enters mobile number and password
3. Password can be toggled visible/hidden with eye icon
4. Form validates input and shows loading state
5. On successful login, redirects to dashboard

### Patient Dashboard
1. Dashboard checks authentication
2. Loads patient information from multiple tables:
   - `patient_register` - Basic info
   - `patient_data` - Additional details (age, address, medical history)
   - `feedback` - Patient's feedback history
   - `messages` - Patient's messages
   - `user_visits` - Last visit information
3. Displays all information in organized cards
4. Shows "NULL" for missing data as requested

### Profile Picture Management
1. Click camera icon on profile picture
2. Select image file (JPG, JPEG, PNG, GIF)
3. File is validated (type and size < 5MB)
4. Old picture is replaced with new one
5. Image is converted to JPG format for consistency

## Database Tables Used

### Existing Tables
- `patient_register` - Patient registration data
- `patient_data` - Additional patient information
- `feedback` - Patient feedback
- `messages` - Patient messages
- `user_visits` - Visit tracking

### New Tables
- `patient_profile_pictures` - Profile picture references

## Security Features
- Session-based authentication
- SQL injection prevention with prepared statements
- File upload validation (type and size)
- XSS prevention with proper output encoding
- CSRF protection through session management

## Responsive Design
- Mobile-first approach
- Tailwind CSS for styling
- Custom dialog boxes
- Loading states and error handling
- Touch-friendly interface

## Error Handling
- Custom dialog boxes for all messages
- Form validation with real-time feedback
- Network error handling
- Database error reporting
- File upload error messages

## Testing
1. Test with existing patient data in your database
2. Verify login with mobile number and password
3. Check all information displays correctly
4. Test profile picture upload functionality
5. Verify responsive design on different devices
6. Test logout functionality

## Troubleshooting

### Common Issues
1. **Login fails**: Check if patient exists in `patient_register` table
2. **No data shows**: Verify patient has records in `patient_data` table
3. **Profile picture upload fails**: Check directory permissions
4. **Session errors**: Ensure PHP sessions are enabled

### Debug Mode
Add this to PHP files for debugging:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## Browser Compatibility
- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Performance Notes
- Images are optimized and converted to JPG
- Database queries use indexes for better performance
- Lazy loading for dashboard data
- Minimal JavaScript for faster loading

## Future Enhancements
- Password reset functionality
- Email notifications
- Appointment booking integration
- Medical records upload
- Two-factor authentication 