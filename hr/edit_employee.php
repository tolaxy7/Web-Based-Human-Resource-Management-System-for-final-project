<?php require 'header.html';?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/home.css">
  <style>
    /* Additional CSS specific to this file */
    table {
      border-collapse: collapse;
      width: 100%;
    }

    thead {
      background-color: #f2f2f2;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #ddd;
    }

    a {
      display: inline-block;
      padding: 8px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      margin-right: 8px;
    }

    a:hover {
      background-color: #3e8e41;
    }
  </style>
</head>
<body>
  
  <table>
    <thead>
      <tr>
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
        <th>Zip</th>
        <th>Country</th>
        <th>Emergency Contact Name</th>
        <th>Emergency Contact Phone</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // Connect to the database
        $db = new PDO('mysql:host=localhost;dbname=hrms', 'root', '');

        // Get the list of employees with department and position names
        $sql = 'SELECT e.name, e.email, e.phone, d.name AS department, p.name AS position, e.start_date, e.end_date, e.salary, e.user_id, e.gender, e.date_of_birth, e.address, e.city, e.state, e.zip, e.country, e.emergency_contact_name, e.emergency_contact_phone FROM employees e
        JOIN departments d ON e.department_id = d.id
        JOIN positions p ON e.position_id = p.id';
        $results = $db->query($sql);

        // Loop through the results and display each employee
        foreach ($results as $row) {
          echo '<tr>';
          echo '<td>' . $row['name'] . '</td>';
          echo '<td>' . $row['email'] . '</td>';
          echo '<td>' . $row['phone'] . '</td>';
          echo '<td>' . $row['department'] . '</td>';
          echo '<td>' . $row['position'] . '</td>';
          echo '<td>' . $row['start_date'] . '</td>';
          echo '<td>' . $row['end_date'] . '</td>';
          echo '<td>' . $row['salary'] . '</td>';
          echo '<td>' . $row['user_id'] . '</td>';
          echo '<td>' . $row['gender'] . '</td>';
          echo '<td>' . $row['date_of_birth'] . '</td>';
          echo '<td>' . $row['address'] . '</td>';
          echo '<td>' . $row['city'] . '</td>';
          echo '<td>' . $row['state'] . '</td>';
          echo '<td>' . $row['zip'] . '</td>';
          echo '<td>' . $row['country'] . '</td>';
          echo '<td>' . $row['emergency_contact_name'] . '</td>';
          echo '<td>' . $row['emergency_contact_phone'] . '</td>';
          echo '<td><a href="edit.php?id=' . $row['id'] . '">Edit</a></td>';
          echo '<td><a href="delete.php?id=' . $row['id'] . '">Delete</a></td>';
          echo '</tr>';
        }

        // Close the database connection
        $db = null;
      ?>
    </tbody>
  </table>
</body>
</html>
