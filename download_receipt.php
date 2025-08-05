<?php
// Database credentials
$servername = "localhost";  // XAMPP MySQL host
$username = "root";         // Database username
$password = "";             // Database password
$dbname = "hospital_management";  // Your database name
$port = 3306; // MySQL default port

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch contact from URL
$contact = $_GET['contact'];

// SQL query to get patient data using the contact number
$sql = "SELECT * FROM patient_data WHERE contact = '$contact'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data for the given contact
    $row = $result->fetch_assoc();
} else {
    echo "No data found for the given contact number.";
    exit();
}

$conn->close();

// Generate Random Appointment Date (3-7 days ahead)
$today = date("Y-m-d");
$appointment_days_ahead = rand(3, 7); // Random number between 3 and 7
$appointment_date = date('Y-m-d', strtotime("$today +$appointment_days_ahead days"));

// Generate Random Appointment Time (between 9 AM to 5 PM)
$hour = rand(9, 17); // Random hour between 9 and 17 (9 AM to 5 PM)
$minute = str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT); // Random minute (00 to 59)
$appointment_time = "$hour:$minute"; // Combine to get the time in HH:MM format

// Prepare the receipt content in an HTML table
$receipt = "
    <html>
    <head>
        <title>Appointment Receipt</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
            }
            th, td {
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .header {
                text-align: center;
                font-size: 24px;
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>Maa Kalawati Hospital Ranchi</h2>
            <h3>Appointment Receipt</h3>
        </div>
        <table>
            <tr>
                <th>Field</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>Hospital Name</td>
                <td>Maa Kalawati Hospital Ranchi</td>
            </tr>
            <tr>
                <td>Full Name</td>
                <td>" . $row['name'] . "</td>
            </tr>
            <tr>
                <td>Age</td>
                <td>" . $row['age'] . "</td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>" . $row['gender'] . "</td>
            </tr>
            <tr>
                <td>Contact Number</td>
                <td>" . $row['contact'] . "</td>
            </tr>
            <tr>
                <td>Submission Time</td>
                <td>" . $row['submission_time'] . "</td>
            </tr>
            <tr>
                <td>Submission Date</td>
                <td>" . $row['submission_date'] . "</td>
            </tr>
            <tr>
                <td>Appointment Date</td>
                <td>" . $appointment_date . "</td>
            </tr>
            <tr>
                <td>Appointment Time</td>
                <td>" . $appointment_time . "</td>
            </tr>
        </table>
    </body>
    </html>
";

// Set headers to force download the file as HTML
header('Content-Type: text/html');
header('Content-Disposition: attachment; filename="appointment_receipt.html"');

// Output the receipt content as HTML
echo $receipt;
?>
