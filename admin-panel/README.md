# Admin Panel for Hospital Management System

## Overview
This project is an Admin Panel for a Hospital Management System that allows administrators to manage patient records effectively. The application provides functionalities for viewing, adding, updating, and deleting patient information, as well as managing admin accounts.

## Features
- Admin login functionality
- Dashboard for managing patients
- View, add, update, and delete patient records
- User-friendly interface for easy navigation

## Project Structure
```
admin-panel
├── src
│   ├── controllers
│   │   ├── adminController.js
│   │   └── patientController.js
│   ├── models
│   │   ├── admin.js
│   │   └── patient.js
│   ├── routes
│   │   ├── adminRoutes.js
│   │   └── patientRoutes.js
│   ├── views
│   │   ├── admin_login.html
│   │   ├── dashboard.html
│   │   └── patient_list.html
│   └── app.js
├── public
│   ├── css
│   │   └── style.css
│   └── js
│       └── main.js
├── package.json
└── README.md
```

## Installation
1. Clone the repository:
   ```
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```
   cd admin-panel
   ```
3. Install the dependencies:
   ```
   npm install
   ```

## Usage
1. Start the application:
   ```
   npm start
   ```
2. Open your browser and go to `http://localhost:3000` to access the admin panel.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License.