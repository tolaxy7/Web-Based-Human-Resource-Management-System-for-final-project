<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrms";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to fetch count from a table
function getCount($conn, $table) {
    $sql = "SELECT COUNT(*) AS count FROM $table";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['count'];
}

// Fetch counts from the database
$employeeCount = getCount($conn, 'employees');
$vacancyCount = getCount($conn, 'vacancies');
$userCount = getCount($conn, 'users');
$scheduleCount = getCount($conn, 'schedules');
$feedbackCount = getCount($conn, 'feedback');
$reportCount = getCount($conn, 'reports');

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        /* Styling for each section */
        .section {
            width: 200px;
            height: 200px;
            margin: 20px;
            padding: 20px;
            text-align: center;
            background-color: #F2F2F2;
            border-radius: 10px;
            display: inline-block;
        }

        /* Color styles for each section */
        .employees { background-color: #FFC300; }
        .vacancies { background-color: #3498DB; }
        .users { background-color: #9B59B6; }
        .schedule { background-color: #2ECC71; }
        .feedback { background-color: #E74C3C; }
        .report { background-color: #F39C12; }
    </style>
</head>
<body>
    <div class="section employees">
        <h2>Employees</h2>
        <p><?php echo $employeeCount; ?></p>
    </div>
    <div class="section vacancies">
        <h2>Vacancies</h2>
        <p><?php echo $vacancyCount; ?></p>
    </div>
    <div class="section users">
        <h2>Users</h2>
        <p><?php echo $userCount; ?></p>
    </div>
    <div class="section schedule">
        <h2>Schedule</h2>
        <p><?php echo $scheduleCount; ?></p>
    </div>
    <div class="section feedback">
        <h2>Feedback</h2>
        <p><?php echo $feedbackCount; ?></p>
    </div>
    <div class="section report">
        <h2>Report</h2>
        <p><?php echo $reportCount; ?></p>
    </div>
</body>
</html>
