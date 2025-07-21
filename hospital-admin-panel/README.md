# Hospital Management System Admin Panel

## Overview
This project is an Admin Panel for a Hospital Management System. It allows administrators to manage patient records, view patient information, and perform various administrative tasks related to hospital management.

## Project Structure
```
hospital-admin-panel
├── admin
│   ├── login.html          # Admin login page
│   ├── dashboard.html      # Admin dashboard after login
│   ├── manage_patients.html # Page to manage patient records
│   ├── css
│   │   └── style.css       # CSS styles for the admin panel
│   ├── js
│   │   └── main.js         # JavaScript functions for interactivity
│   └── php
│       ├── login.php       # PHP script for processing admin login
│       ├── logout.php      # PHP script for handling admin logout
│       ├── get_patients.php # PHP script to retrieve patient records
│       ├── add_patient.php  # PHP script to add a new patient
│       ├── update_patient.php # PHP script to update patient information
│       ├── delete_patient.php # PHP script to delete a patient record
│       └── track_patient.php  # PHP script to track patient information
├── db
│   └── config.php          # Database configuration settings
├── Images                   # Directory for images used in the admin panel
├── index.html              # Landing page for the hospital management system
└── README.md               # Documentation for the project
```

## Features
- **Admin Login**: Secure login for administrators to access the panel.
- **Dashboard**: Overview of the hospital management system with quick links to manage patients.
- **Manage Patients**: View, add, update, and delete patient records with a user-friendly interface.
- **Responsive Design**: The admin panel is designed to be responsive and user-friendly across devices.

## Setup Instructions
1. **Clone the Repository**: Clone this repository to your local machine.
2. **Database Setup**: 
   - Create a MySQL database and import the necessary tables for patient records.
   - Update the `db/config.php` file with your database connection details.
3. **Run the Application**: 
   - Use a local server environment (like XAMPP) to run the application.
   - Access the admin login page via `http://localhost/hospital-admin-panel/admin/login.html`.

## Usage
- Navigate to the login page to enter admin credentials.
- After logging in, access the dashboard to manage patient records.
- Use the manage patients page to view, add, update, or delete patient information.

## Contributing
Contributions are welcome! Please feel free to submit a pull request or open an issue for any suggestions or improvements.

## License
This project is licensed under the MIT License.