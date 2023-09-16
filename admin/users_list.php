<?php
include 'header.html';
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrms";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all users from database
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Close database connection
$conn->close();

?>
<head>
    <style>
        table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
  font-weight: bold;
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
<h2>List of Users:</h2>

<table>
  <tr>
    <th>ID</th>
    <th>Username</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Action</th>
  </tr>
  
  <?php
  // Display list of users
  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["id"] . "</td>";
          echo "<td>" . $row["username"] . "</td>";
          echo "<td>" . $row["first_name"] . "</td>";
          echo "<td>" . $row["last_name"] . "</td>";
          echo "<td>" . $row["email"] . "</td>";
          echo "<td><a href='update_user.php?id=" . $row["id"] . "'>Update</a></td>";
          echo "<td><a href='delete_user.php?id=" . $row["id"] . "'>delete</a></td>";
          echo "</tr>";
      }
  } else {
      echo "<tr><td colspan='6'>No users found.</td></tr>";
  }
  ?>
  
</table>
