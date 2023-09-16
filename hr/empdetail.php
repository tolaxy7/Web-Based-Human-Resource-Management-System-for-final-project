
<!DOCTYPE html>
<html>
<head>
    <title>Employee Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<?php

require 'header.html';
// Establish database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "hrms";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch employee data from the database
$query = "SELECT * FROM employees";
$result = mysqli_query($conn, $query);

// Display employee data in an HTML table
echo '<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Position</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Salary</th>
                <th>User ID</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>ZIP</th>
                <th>Country</th>
                <th>Emergency Contact Name</th>
                <th>Emergency Contact Phone</th>
            </tr>
        </thead>
        <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <td>' . $row['id'] . '</td>
            <td>' . $row['name'] . '</td>
            <td>' . $row['email'] . '</td>
            <td>' . $row['phone'] . '</td>
            <td>' . $row['department'] . '</td>
            <td>' . $row['position'] . '</td>
            <td>' . $row['start_date'] . '</td>
            <td>' . $row['end_date'] . '</td>
            <td>' . $row['salary'] . '</td>
            <td>' . $row['user_id'] . '</td>
            <td>' . $row['gender'] . '</td>
            <td>' . $row['date_of_birth'] . '</td>
            <td>' . $row['address'] . '</td>
            <td>' . $row['city'] . '</td>
            <td>' . $row['state'] . '</td>
            <td>' . $row['zip'] . '</td>
            <td>' . $row['country'] . '</td>
            <td>' . $row['emergency_contact_name'] . '</td>
            <td>' . $row['emergency_contact_phone'] . '</td>
        </tr>';
}

echo '</tbody>
    </table>';

// Close database connection
mysqli_close($conn);
?>
</body>
</html>
