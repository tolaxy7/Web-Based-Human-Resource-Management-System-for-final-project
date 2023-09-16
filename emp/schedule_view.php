<?php
include 'header.html';

// Assuming you have established a database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hrms';

// Establish a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check if user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ../login.php');
  exit;
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the employee ID from the employees table based on the user ID
$stmt = $conn->prepare("SELECT id FROM employees WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$employee_id = $row['id'];
$stmt->close();

// Retrieve the schedule for the employee
$stmt = $conn->prepare("SELECT day, start_time, end_time FROM schedules WHERE employee_id = ?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();

// Display the schedule in a table
echo "<h1>My Schedule</h1>";
echo "<table>";
echo "<tr><th>Day</th><th>Start Time</th><th>End Time</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['day'] . "</td>";
    echo "<td>" . $row['start_time'] . "</td>";
    echo "<td>" . $row['end_time'] . "</td>";
    echo "</tr>";
}
echo "</table>";

// Close the statement and database connection
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Schedule</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
</body>
</html>
