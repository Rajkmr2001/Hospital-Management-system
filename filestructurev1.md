# Hospital Backend - Complete File Structure v1

```text
hospital_backend/
├── .git/                                    # Git repository
├── .vscode/
│   └── settings.json                        # VS Code workspace settings
├── .gitignore                               # Git ignore patterns
├── index.html                               # Main homepage (45KB)
├── About Us.html                            # About page (25KB)
├── book-now.html                            # Appointment booking page (3.6KB)
├── Cardiac_Sciences.html                    # Cardiology department page (27KB)
├── contact.html                             # Contact page (25KB)
├── creator.html                             # Creator/developer page (12KB)
├── Dental_Science.html                      # Dental department page (25KB)
├── Dermatology.html                         # Dermatology department page (26KB)
├── Emergency_Services.html                  # Emergency services page (25KB)
├── ENT.html                                 # ENT department page (25KB)
├── faqs.html                                # FAQ page (20KB)
├── feedback.html                            # Feedback page (26KB)
├── Gastroenterology.html                    # Gastroenterology page (25KB)
├── Infectious_Diseases.html                 # Infectious diseases page (24KB)
├── Laboratory_Diagnostics.html              # Lab services page (27KB)
├── Neurology.html                           # Neurology department page (28KB)
├── nurses.html                              # Nurses page (19KB)
├── Ophthalmology.html                       # Ophthalmology page (28KB)
├── Pharmacy_Services.html                   # Pharmacy services page (26KB)
├── Radiology.html                           # Radiology department page (26KB)
├── Weight_Scale.html                        # Weight management page (23KB)
├── doctors.html                             # Doctors listing page (23KB)
├── doctor_aryas.html                        # Dr. Aryas profile page (19KB)
├── Doctor_Dr. Kusum.html                    # Dr. Kusum profile page (19KB)
├── Doctor_Dr. Sitara.html                   # Dr. Sitara profile page (19KB)
├── Doctor_Dr. swyeta.html                   # Dr. Swyeta profile page (19KB)
├── doctor_Nirmala.html                      # Dr. Nirmala profile page (18KB)
├── doctor_williams.html                     # Dr. Williams profile page (17KB)
├── login.html                               # Patient login page (4.2KB)
├── patient_login.html                       # Patient login form (8.7KB)
├── patient_registration.html                # Patient registration form (8.9KB)
├── patient_dashboard.html                   # Patient dashboard (18KB)
├── patient_dashboard.js                     # Patient dashboard JavaScript (20KB)
├── receptxxx.html                           # Receipt template (3.7KB)
├── style.css                                # Main stylesheet (6.3KB)
├── script.js                                # Main JavaScript (1.5KB)
├── messages.json                            # Messages data (227B)
├── version.txt                              # Version information (2.3KB)
├── PROJECT_STRUCTURE.md                     # Project structure documentation (7.1KB)
├── filestructurev1.md                       # This file structure document
├── GIT_WORKFLOW_GUIDE.md                    # Git workflow documentation (4.8KB)
├── XAMPP_SETUP_GUIDE.md                     # XAMPP setup instructions (4.4KB)
├── ADMIN_AUTHENTICATION_SETUP.md            # Admin auth setup guide (6.2KB)
├── TROUBLESHOOTING_GUIDE.md                 # Troubleshooting guide (5.2KB)
├── SETUP_INSTRUCTIONS.md                    # General setup instructions
├── xampp_database_setup.sql                 # XAMPP database schema (11KB)
├── infinityfree_complete_database.sql       # InfinityFree database schema (13KB)
├── setup_admin_auth.php                     # Admin authentication setup (3.1KB)
├── update_admins_table.php                  # Admin table migration (2.7KB)
├── check_patient_auth.php                   # Patient auth check (415B)
├── download_receipt.php                     # Receipt download handler (3.8KB)
├── fetch_name.php                           # Name fetch utility (966B)
├── get_patient_dashboard_data.php           # Patient dashboard data API (4.8KB)
├── messages.php                              # Messages handler (1.7KB)
├── patient_login.php                         # Patient login handler (2.0KB)
├── patient_logout.php                        # Patient logout handler (283B)
├── register.php                              # Patient registration handler (1.6KB)
├── reset_test_password.php                   # Password reset utility (4.3KB)
├── show_pdata.php                            # Patient data display (5.9KB)
├── submit_form.php                           # Form submission handler (1.6KB)
├── submit_message.php                        # Message submission (2.4KB)
├── submit_message_fixed.php                  # Fixed message submission (2.4KB)
├── update_patient_info.php                   # Patient info update (4.9KB)
├── upload_profile_picture.php                # Profile picture upload (1.7KB)
├── db/                                      # Database configuration & utilities
│   ├── config.php                           # Database connection config (489B)
│   ├── fetch_namesss.php                    # Name fetch utility (966B)
│   ├── get_feedback.php                     # Feedback retrieval (600B)
│   ├── like_feedback.php                    # Feedback like handler (1.2KB)
│   └── submit_feedback.php                  # Feedback submission (939B)
├── php/                                     # PHP API endpoints
│   ├── get_user_visits_stats.php            # User visits analytics API (5.5KB)
│   ├── api_get_feedback_stats.php           # Feedback stats API (1.2KB)
│   ├── api_get_user_visits_stats.php        # User visits stats API (1.2KB)
│   ├── delete_feedback.php                  # Feedback deletion (1.0KB)
│   ├── fetch_namesss.php                    # Name fetch utility (966B)
│   ├── get_feedback.php                     # Feedback retrieval (1.6KB)
│   ├── get_feedback_with_timestamps.php     # Feedback with timestamps (2.1KB)
│   ├── like_feedback.php                    # Feedback like handler (2.9KB)
│   └── submit_feedback.php                  # Feedback submission (1.2KB)
├── Images/                                  # Main image assets
│   ├── logo.webp                            # Hospital logo (7.8KB)
│   ├── maa_Kalawati.jpg                     # Hospital main image (259KB)
│   ├── maa_kalawati.png                     # Hospital logo PNG (790KB)
│   ├── default-avatar.png                   # Default user avatar (168B)
│   ├── Cardiac Sciences.jpg                 # Cardiology image (146KB)
│   ├── Dental Science.avif                  # Dental science image (2.2KB)
│   ├── Dermatology.jpeg                     # Dermatology image (102KB)
│   ├── Dermatology1.jpg                     # Dermatology image 2 (73KB)
│   ├── Emergency and Trauma.jpg             # Emergency services image (147KB)
│   ├── emergency-hero.jpg                   # Emergency hero image (34KB)
│   ├── ent.jpg                              # ENT image (233KB)
│   ├── ENT.png                              # ENT logo (49KB)
│   ├── faq-hero.jpg                         # FAQ hero image (22KB)
│   ├── Foetal Medicine.jpeg                 # Foetal medicine image (158KB)
│   ├── Gastroenterology.jpg                 # Gastroenterology image (56KB)
│   ├── hero_infectious.jpg                  # Infectious diseases hero (317KB)
│   ├── Infectious Diseases.jpg              # Infectious diseases image (182KB)
│   ├── Lab_images1.jpg                      # Laboratory image (47KB)
│   ├── Laboratory_Diagnostics.jpg           # Lab diagnostics image (27KB)
│   ├── Neurology.jpg                        # Neurology image (970KB)
│   ├── Neurology Services.jpeg              # Neurology services (8.6KB)
│   ├── new1.jpg through new9.jpg            # Hero/feature images (14KB-158KB)
│   ├── Ophthalmology.jpg                    # Ophthalmology image (68KB)
│   ├── ophthalmology11.jpg                  # Ophthalmology image 2 (30KB)
│   ├── Orthopedics.jpg                      # Orthopedics image (83KB)
│   ├── Pediatrics.jpg                       # Pediatrics image (60KB)
│   ├── pharmaceutical-industry.jpg          # Pharmaceutical image (131KB)
│   ├── pexels-photo-*.webp                 # Stock photos (16KB-31KB)
│   ├── Psychiatry.jpg                       # Psychiatry image (163KB)
│   ├── Radiology.jpg                        # Radiology image (79KB)
│   ├── weight-hero.jpg                      # Weight management hero (29KB)
│   └── istockphoto-*.jpg                    # Stock photos (17KB-32KB)
├── profile_pictures/                        # User profile pictures
│   ├── 9001234567.jpg                       # Profile picture (21KB)
│   ├── 9142428888.jpg                       # Profile picture (438KB)
│   ├── 9142704414.jpg                       # Profile picture (37KB)
│   ├── 9572946107.jpg                       # Profile picture (37KB)
│   ├── 9873216540.jpg                       # Profile picture (104KB)
│   ├── 9900786549.jpg                       # Profile picture (555KB)
│   ├── 9911223344.jpg                       # Profile picture (97KB)
│   └── 9988770012.jpg                       # Profile picture (555KB)
└── hospital-admin-panel/                    # Admin panel system
    ├── admin-portal.html                    # Admin portal entry (1.0KB)
    ├── setup_patient_management.php         # Patient management setup (4.7KB)
    ├── ADMIN_PANEL_WORKFLOW.txt             # Admin workflow documentation (7.7KB)
    ├── check_gender.php                     # Gender check utility (214B)
    ├── Images/                              # Admin panel images
    ├── db/                                  # Admin database config
    │   └── config.php                       # Admin DB connection (489B)
    └── admin/                               # Admin panel core
        ├── dashboard_auth.php               # Dashboard authentication (1.3KB)
        ├── dashboard.php                    # Main admin dashboard (13KB)
        ├── login.php                        # Admin login page (12KB)
        ├── manage_appointments.html         # Appointment management (5.6KB)
        ├── manage_feedback.php              # Feedback management (19KB)
        ├── manage_messages.php              # Messages management (15KB)
        ├── manage_patients.php              # Patient management (22KB)
        ├── manage_registered_persons.php    # Registered persons management (21KB)
        ├── styledb.css                      # Admin panel styles (8.4KB)
        ├── user_visits.php                  # User visits analytics (25KB)
        ├── txt11.php                        # Admin utility (legacy)
        ├── css/                             # Admin CSS assets (empty)
        ├── js/                              # Admin JavaScript assets (empty)
        └── php/                             # Admin PHP endpoints
            ├── log_user_visit.php           # User visit logging (2.5KB)
            ├── get_user_visits_stats.php    # User visits stats (2.3KB)
            ├── login.php                    # Admin login handler (3.0KB)
            ├── logout.php                   # Admin logout handler (199B)
            ├── auth_check.php               # Authentication check (388B)
            ├── add_patient.php              # Patient addition (1.5KB)
            ├── update_patient.php           # Patient update (1.6KB)
            ├── delete_patient.php           # Patient deletion (878B)
            ├── delete_patient_data.php      # Patient data deletion (808B)
            ├── get_patient.php              # Patient retrieval (573B)
            ├── get_patients.php             # Patients listing (328B)
            ├── get_patient_data.php         # Patient data retrieval (547B)
            ├── track_patient.php            # Patient tracking (1.9KB)
            ├── get_appointments.php         # Appointments retrieval (631B)
            ├── delete_appointment.php       # Appointment deletion (805B)
            ├── get_messages.php             # Messages retrieval (545B)
            ├── delete_message.php           # Message deletion (605B)
            ├── get_feedback.php             # Feedback retrieval
            ├── delete_feedback.php          # Feedback deletion (792B)
            ├── get_registered_persons.php   # Registered persons retrieval (1.6KB)
            ├── update_registered_person.php # Registered person update (2.8KB)
            ├── delete_registered_person.php # Registered person deletion (1.3KB)
            ├── get_total_patients.php       # Total patients count (409B)
            ├── get_total_registered_persons.php # Total registered count (584B)
            ├── get_total_messages.php       # Total messages count (405B)
            ├── get_total_feedback.php       # Total feedback count (405B)
            ├── get_total_user_visits.php    # Total visits count (423B)
            ├── test_messages_table.php      # Messages table test (1.0KB)
            └── resume_raj.html              # Resume page (7.0KB)
```

## File Count Summary

### HTML Pages: 35+
- Main pages: index.html, About Us.html, contact.html, feedback.html
- Department pages: Cardiac_Sciences.html, Dental_Science.html, Dermatology.html, etc.
- Doctor profiles: doctor_aryas.html, Doctor_Dr. Kusum.html, etc.
- Patient pages: patient_login.html, patient_registration.html, patient_dashboard.html
- Admin pages: admin-portal.html, login.php, dashboard.php, etc.

### PHP Scripts: 50+
- API endpoints: get_user_visits_stats.php, submit_feedback.php, etc.
- Admin handlers: add_patient.php, update_patient.php, delete_patient.php, etc.
- Patient handlers: patient_login.php, register.php, update_patient_info.php, etc.
- Database utilities: config.php, fetch_namesss.php, etc.

### Image Assets: 50+
- Department images: Cardiac Sciences.jpg, Dermatology.jpeg, etc.
- Hero images: new1.jpg through new9.jpg
- Stock photos: istockphoto-*.jpg, pexels-photo-*.webp
- Profile pictures: 8 user profile images
- Logo and branding: logo.webp, maa_Kalawati.jpg

### Configuration Files: 10+
- Database: db/config.php, hospital-admin-panel/db/config.php
- Documentation: *.md files, *.txt files
- Setup scripts: setup_admin_auth.php, update_admins_table.php
- Database schemas: xampp_database_setup.sql, infinityfree_complete_database.sql

## Key Features

### Frontend
- Responsive hospital website with multiple department pages
- Patient registration and login system
- Patient dashboard with profile management
- Contact forms and feedback system
- Doctor profiles and department information

### Backend
- Patient management system
- Admin panel with comprehensive controls
- User analytics and visit tracking
- Feedback and message management
- Appointment scheduling system

### Database
- Patient registration and data storage
- Admin authentication system
- User visits tracking
- Feedback and messages storage
- Profile picture management

## Deployment Ready

This project is configured for both local development (XAMPP) and production deployment (InfinityFree):
- Database credentials automatically switch based on environment
- No CREATE VIEW dependencies (InfinityFree compatible)
- Optimized for shared hosting environments
- Responsive design for mobile and desktop

## Total Project Size
- **Files**: 150+ files
- **Directories**: 15+ directories
- **Total Size**: Approximately 50MB+ (including images)
- **Lines of Code**: 10,000+ lines across PHP, HTML, CSS, and JavaScript
