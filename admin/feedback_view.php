<?php require 'header.html'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>View Feedbacks</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
    font-family: Arial, sans-serif;
}

h1 {
    text-align: center;
}

table {
    margin: 0 auto;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}
  </style>
</head>
<body>
    <h1>View Feedbacks</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Employee ID</th>
            <th>Feedback Type</th>
            <th>Feedback Text</th>
        </tr>
        <?php
       
        // Include database configuration file
        require_once 'db_connect.php';

        // Fetch feedbacks from database
        $sql = "SELECT * FROM feedback";
        $result = mysqli_query($conn, $sql);

        // Display feedbacks in table
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['employee_id'] . "</td>";
                echo "<td>" . $row['feedback_type'] . "</td>";
                echo "<td>" . $row['feedback_text'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No feedbacks found.</td></tr>";
        }

        // Close database connection
        mysqli_close($conn);
        ?>
    </table>
</body>
</html>