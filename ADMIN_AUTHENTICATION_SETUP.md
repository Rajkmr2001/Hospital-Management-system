# Admin Authentication System Setup

## Overview
This document explains the admin authentication system that has been implemented for the Maa Kalawati Hospital management system.

## What Was Implemented

        ### 1. Admin Login Page
        - **File**: `hospital-admin-panel/admin/login.html`
        - **Features**:
          - Modern, responsive design matching the hospital's color scheme
          - Mobile number and password fields with validation
          - Password visibility toggle
          - Loading states and error handling
          - AJAX form submission for better UX

### 2. Authentication Backend
- **Login Handler**: `hospital-admin-panel/admin/php/login.php`
- **Logout Handler**: `hospital-admin-panel/admin/php/logout.php`
- **Session Protection**: `hospital-admin-panel/admin/php/auth_check.php`
- **Features**:
  - Secure password hashing using PHP's `password_hash()`
  - Session-based authentication
  - Database validation of admin credentials
  - Automatic redirect to login for unauthorized access

### 3. Protected Dashboard
- **File**: `hospital-admin-panel/admin/dashboard.php` (converted from .html)
- **Features**:
  - Session authentication check at the top
  - Displays logged-in admin username
  - Logout functionality in the profile dropdown
  - All existing dashboard functionality preserved

        ### 4. Database Structure
        - **Table**: `admins`
        - **Fields**:
          - `id` (Primary Key)
          - `username` (Unique)
          - `mobile_number` (Unique)
          - `password` (Hashed)
          - `email`
          - `full_name`
          - `role`
          - `created_at`
          - `last_login`
          - `is_active`

## Setup Instructions

### Step 1: Run the Setup Script
1. Open your browser and navigate to: `http://localhost/hospital_backend/setup_admin_auth.php`
2. This will create the admins table and insert a default admin user
3. You should see success messages for each step

### Step 2: Access the Admin Login
1. Go to your main page: `http://localhost/hospital_backend/index.html`
2. Click on the "Login" dropdown in the navigation
3. Select "Admin Login"
4. You'll be redirected to the admin login page

        ### Step 3: Login with Default Credentials
        - **Mobile Number**: `9876543210`
        - **Password**: `admin123`

### Step 4: Access the Protected Dashboard
After successful login, you'll be redirected to the dashboard with full access to all admin features.

## Security Features

### 1. Password Security
- Passwords are hashed using PHP's `password_hash()` function
- Uses bcrypt algorithm with cost factor 10
- Salt is automatically generated and stored with the hash

### 2. Session Security
- Session-based authentication prevents unauthorized access
- Sessions are validated on every page load
- Automatic logout on session expiration

### 3. Database Security
- Prepared statements prevent SQL injection
- Input validation and sanitization
- Unique username constraint

### 4. Access Control
- All admin pages now require authentication
- Automatic redirect to login for unauthorized users
- Logout functionality to end sessions

        ## File Structure

        ```
        hospital_backend/
        ├── hospital-admin-panel/
        │   └── admin/
        │       ├── login.html                    # Admin login page
        │       ├── dashboard.php                 # Protected dashboard
        │       └── php/
        │           ├── login.php                 # Login handler
        │           ├── logout.php                # Logout handler
        │           └── auth_check.php            # Session protection
        ├── setup_admin_auth.php                  # Setup script
        ├── update_admins_table.php               # Migration script
        └── create_admins_table.sql               # Database schema
        ```

## Important Notes

        ### 1. Default Credentials
        - The default mobile number is `9876543210`
        - The default password is `admin123`
        - **IMPORTANT**: Change these credentials after your first login for security

### 2. Database Connection
- The system uses the updated database configuration with port 3307
- Make sure your MySQL server is running on the correct port

### 3. Session Management
- Sessions are stored on the server
- Sessions expire when the browser is closed (unless configured otherwise)
- Users must log in again after session expiration

### 4. Error Handling
- Login errors are displayed to the user
- Database connection errors are logged
- Invalid credentials are handled gracefully

## Troubleshooting

### Common Issues

1. **"Connection failed" error**
   - Check if MySQL is running on port 3307
   - Verify database credentials in `db/config.php`

        2. **"No admin found" error**
           - Run the setup script again: `setup_admin_auth.php`
           - Or run the migration script: `update_admins_table.php`
           - Check if the admins table was created successfully

3. **"Session not working"**
   - Ensure PHP sessions are enabled
   - Check file permissions for session storage

4. **"Page not found" errors**
   - Verify all files are in the correct locations
   - Check file permissions

### Testing the System

1. **Test Login**: Try logging in with correct credentials
2. **Test Invalid Login**: Try incorrect credentials to see error handling
3. **Test Session**: Close browser and try to access dashboard directly
4. **Test Logout**: Use logout button and verify redirect to login

## Next Steps

After successful setup, consider:

1. **Change Default Password**: Create a new admin user or change the default password
2. **Add More Admins**: Use the database to add additional admin users
3. **Customize Login Page**: Modify the login page design if needed
4. **Add Password Reset**: Implement password reset functionality
5. **Add Two-Factor Authentication**: Enhance security with 2FA

## Support

If you encounter any issues:
1. Check the browser console for JavaScript errors
2. Check the PHP error logs
3. Verify database connectivity
4. Ensure all files are properly uploaded and accessible 