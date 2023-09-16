<?php
// Include database connection file
include 'db_connect.php';

// Retrieve data from the users table
$sql = "SELECT first_Name, last_Name, email, phone, department, position FROM users";
$result = $conn->query($sql);

// Check if records exist
if ($result->num_rows > 0) {
  // Loop through each record
  while ($row = $result->fetch_assoc()) {
    // Check if the required keys exist in the $row array
    if (isset($row['first_Name'], $row['last_Name'], $row['email'], $row['phone'], $row['department'], $row['position'])) {
      $firstName = $row['firstName'];
      $lastName = $row['lastName'];
      $email = $row['email'];
      $phone = $row['phone'];
      $department = $row['department'];
      $position = $row['position'];

      // Define an array of colors
      $colors = array('red', 'blue', 'green', 'yellow', 'orange');

      // Generate a random color
      $randomColor = $colors[array_rand($colors)];

      // Display the data as colored rectangles
      echo '<div style="background-color: ' . $randomColor . '; padding: 10px; margin-bottom: 10px;">';
      echo '<p>First Name: ' . $firstName . '</p>';
      echo '<p>Last Name: ' . $lastName . '</p>';
      echo '<p>Email: ' . $email . '</p>';
      echo '<p>Phone: ' . $phone . '</p>';
      echo '<p>Department: ' . $department . '</p>';
      echo '<p>Position: ' . $position . '</p>';
      echo '</div>';
    } else {
      echo 'Incomplete data found for a user.';
    }
  }
} else {
  echo 'No records found.';
}

// Close the database connection
$conn->close();
?>
