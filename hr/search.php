<?php
require 'header.html';

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=hrms', 'root', '');

// Check if the search form has been submitted
if (isset($_POST['search'])) {
  // Get the search term
  $searchTerm = $_POST['search'];

  // Prepare the SQL query
  $sql = "SELECT * FROM employees WHERE name LIKE :searchTerm OR id LIKE :searchTerm OR department LIKE :searchTerm ";
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%', PDO::PARAM_STR);

  // Execute the query
  $stmt->execute();

  // Fetch the results
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Check if any results were found
  if (count($results) > 0) {
    // Display the results in a table
    echo '<table>';
    echo '<thead>';
    echo '<tr><th>Name</th><th>Email</th><th>Phone</th><th>Department</th><th>Position</th><th>Start Date</th><th>End Date</th><th>Salary</th><th>User ID</th><th>Gender</th><th>Date of Birth</th><th>Address</th><th>City</th><th>State</th><th>Zip</th><th>Country</th><th>Emergency Contact Name</th><th>Emergency Contact Phone</th></tr>';
    echo '</thead>';
    echo '<tbody>';
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
    echo '</tbody>';
    echo '</table>';
  } else {
    // No results were found
    echo 'No results found for "' . $searchTerm . '"';
  }
}
?>

<head>
  <link rel="stylesheet" href="css/search.css">
</head>

<!-- Display the search form -->
<form method="post">
  <label for="search">Search by ID, Name, Department</label>
  <input type="text" id="search" name="search">
  <button type="submit">Search</button>
</form>
