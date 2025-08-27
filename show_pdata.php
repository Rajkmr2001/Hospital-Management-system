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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Receipt - Maa Kalawati Hospital</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f1eb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .receipt-container {
            width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 3px solid #009c1a;
            position: relative;
        }
        .background-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.2;
            width: 300px;
            height: auto;
        }
        .header {
            text-align: center;
            color: green;
            font-size: 24px;
            font-weight: bold;
            text-decoration: underline;
        }
        .sub-header {
            font-size: 16px;
            color: black;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            position: relative;
            z-index: 1;
        }
        td {
            padding: 5px;
            font-weight: bold;
        }
        .signature {
            margin-top: 20px;
            font-weight: bold;
            text-align: right;
            position: relative;
            z-index: 1;
        }
        .auto-signature {
            font-family: 'Brush Script MT', cursive;
            font-size: 18px;
        }
        .download-btn {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
           
        }
        .btn-success {
            background-color: #009c1a;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn-success:hover {
            background-color: #007a15;
        }
    </style>
</head>
<body>
    <div class="receipt-container" id="receipt">
        <img src="Images/logo.webp" alt="Hospital Logo" class="background-logo">
        <div class="header">MAA KALAWATI HOSPITAL</div>
        <div class="sub-header">Medical Receipt</div>

        <table>
            <tr><td>Name:</td><td><?php echo $row['name']; ?></td></tr>
            <tr><td>Age:</td><td><?php echo $row['age']; ?></td></tr>
            <tr><td>Gender:</td><td><?php echo $row['gender']; ?></td></tr>
            <tr><td>Address:</td><td><?php echo $row['address']; ?></td></tr>
            <tr><td>Contact:</td><td><?php echo $row['contact']; ?></td></tr>
            <tr><td>Date of Enrollment:</td><td><?php echo $row['submission_date']; ?></td></tr>
            <tr><td>Time of Enrollment:</td><td><?php echo $row['submission_time']; ?></td></tr>
            <tr><td>Appointment Date:</td><td><?php echo $appointment_date; ?></td></tr>
            <tr><td>Appointment Time:</td><td><?php echo $appointment_time; ?></td></tr>
        </table>

        <div class="signature">
            <strong>Signature:</strong> <span class="auto-signature">Dr. XYZ</span>
            <br>(Hospital Manager)
        </div>

        <p style="text-align: center; margin-top: 20px;">Thank you for your business!</p>

    </div>
    
    <div class="download-btn">
            <button onclick="downloadPDF()" class="btn-success">Download Receipt</button>
        </div>


    <script>
        function downloadPDF() {
            html2canvas(document.getElementById("receipt")).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF();
                pdf.addImage(imgData, "PNG", 10, 10, 180, 0);
                pdf.save("Medical_Receipt.pdf");
            });
        }
    </script>
</body>
</html>
