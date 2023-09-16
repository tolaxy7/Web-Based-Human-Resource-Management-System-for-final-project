<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee List</title>
  <link rel="stylesheet" href="css/list.css">
</head>
<body>
  <?php include 'header.html'; ?>
  <div class="container">
    <header>
      <h1>Employee List</h1>
    </header>
    <main>
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
          </tr>
        </thead>
        <tbody>
          <?php
          
          // Connect to the database
          $db = new PDO('mysql:host=localhost;dbname=hrms', 'root', '');

          // Get the list of employees
          $sql = 'SELECT * FROM employees';
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
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
    </main>
    <footer>
      <p>Copyright &copy; 2023</p>
    </footer>
  </div>
</body>
</html>
