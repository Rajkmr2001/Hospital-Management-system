 # XAMPP Local Development Setup Guide

## 🚀 **Complete Setup for Hospital Management System on XAMPP**

### ✅ **What's Been Done:**
1. **Database Configuration Updated** - All PHP files now use localhost credentials
2. **SQL File Created** - `xampp_database_setup.sql` ready for import
3. **View Logic Removed** - No more CREATE VIEW statements (InfinityFree compatibility maintained)

### 📋 **Step-by-Step Setup Instructions:**

#### **1. Start XAMPP Services:**
- Open XAMPP Control Panel
- Start **Apache** service
- Start **MySQL** service
- Both should show green status

#### **2. Create Database:**
- Open browser: `http://localhost/phpmyadmin`
- Click "New" to create a new database
- Database name: `hospital_management`
- Click "Create"

#### **3. Import Database Structure:**
- Select the `hospital_management` database
- Click "SQL" tab
- Copy entire contents of `xampp_database_setup.sql`
- Paste into SQL query box
- Click "Go" to execute

#### **4. Verify Database Setup:**
After import, you should see these tables:
- ✅ `messages` (contact form submissions)
- ✅ `patient_register` (patient registration)
- ✅ `patient_data` (admin panel patient info)
- ✅ `patients` (basic patient info)
- ✅ `admins` (admin authentication)
- ✅ `feedback` (patient feedback)
- ✅ `feedback_likes` (feedback likes)
- ✅ `patient_profile_pictures` (profile pictures)
- ✅ `appointments` (appointment system)
- ✅ `user_visits` (visit tracking)

#### **5. Test Your Website:**
- Open browser: `http://localhost/hospital_backend/`
- Your hospital website should load
- Test contact form, patient registration, etc.

### 🔐 **Default Login Credentials:**

#### **Admin Panel:**
- URL: `http://localhost/hospital_backend/hospital-admin-panel/admin/login.html`
- Username: `admin`
- Password: `admin123`

#### **Patient Login:**
- URL: `http://localhost/hospital_backend/patient_login.html`
- Use any of the sample patient credentials:
  - Mobile: `9873216540`, Password: `admin123`
  - Mobile: `9900786549`, Password: `admin123`
  - Mobile: `9911223344`, Password: `admin123`

### 📁 **Key Files Updated for XAMPP:**

#### **Database Configuration Files:**
- ✅ `db/config.php` - Main database connection
- ✅ `hospital-admin-panel/db/config.php` - Admin panel connection

#### **PHP Files Updated:**
- ✅ `update_patient_info.php`
- ✅ `submit_message_fixed.php`
- ✅ `submit_message.php`
- ✅ `submit_form.php`
- ✅ `show_pdata.php`
- ✅ `register.php`
- ✅ `patient_login.php`
- ✅ `messages.php`
- ✅ `get_patient_dashboard_data.php`
- ✅ `fetch_name.php`
- ✅ `download_receipt.php`
- ✅ `db/fetch_namesss.php`
- ✅ `php/submit_feedback.php`
- ✅ `php/like_feedback.php`
- ✅ `php/get_user_visits_stats.php`
- ✅ `php/get_feedback_with_timestamps.php`
- ✅ `php/get_feedback.php`
- ✅ `php/fetch_namesss.php`
- ✅ `php/delete_feedback.php`
- ✅ `hospital-admin-panel/admin/php/login.php`

### 🗄️ **Database Credentials (XAMPP):**
```php
$host = "localhost";
$username = "hospit27_admin_raj";
$password = "Rajftp957294";
$dbname = "hospital_management";
$port = 3306;
```

### 🔧 **Troubleshooting:**

#### **If Database Connection Fails:**
1. Check XAMPP MySQL service is running
2. Verify database name is `hospital_management`
3. Check MySQL port (default: 3306)

#### **If Website Doesn't Load:**
1. Check XAMPP Apache service is running
2. Verify file path: `C:\xampp\htdocs\hospital_backend\`
3. Check browser URL: `http://localhost/hospital_backend/`

#### **If Admin Panel Doesn't Work:**
1. Verify admin credentials: `admin` / `admin123`
2. Check database tables are created
3. Verify `admins` table has sample data

### 📝 **Sample Data Included:**
- 1 admin user (admin/admin123)
- 3 sample patients with login credentials
- Sample contact form messages
- Sample feedback entries
- Sample appointments
- Sample user visit data

### 🎯 **Next Steps:**
1. Import the database using `xampp_database_setup.sql`
2. Test all website features
3. Customize content as needed
4. Add more patients/users as required

### 📞 **Support:**
If you encounter any issues:
1. Check XAMPP error logs
2. Verify all services are running
3. Ensure database import was successful
4. Test with sample credentials first

---

**Your hospital management system is now ready for local development on XAMPP!** 🏥