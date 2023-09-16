<!DOCTYPE html>
<html>
<head>
    <title>View Schedules</title>
    <link rel="stylesheet" type="text/css" href="css/scheduleview.css">
    <style>
        /* scheduleview.css */

body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 20px;
}

h1 {
  text-align: center;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th,
td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
}

tr:hover {
  background-color: #f5f5f5;
}

a {
  color: #007bff;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

    </style>
</head>
<body>
    <?php include 'header.html';?>
    <h1>View Schedules</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Employee ID</th>
            <th>Day</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php
        // Include database configuration file
        require_once 'db_connect.php';

        // Fetch schedules from database
        $sql = "SELECT * FROM schedules";
        $result = mysqli_query($conn, $sql);

        // Display schedules in table
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['employee_id'] . "</td>";
                echo "<td>" . $row['day'] . "</td>";
                echo "<td>" . $row['start_time'] . "</td>";
                echo "<td>" . $row['end_time'] . "</td>";
                echo "<td><a href='edit.php?id=" . $row['id'] . "'>Edit</a></td>";
                echo "<td><a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this schedule?\")'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No schedules found.</td></tr>";
        }

        // Close database connection
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>