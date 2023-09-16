<?php
// Start session
session_start();

// Check if user is logged in and is an employee
if (!isset($_SESSION['username']) || !isset($_SESSION['is_employee']) || !$_SESSION['is_employee']) {
  header("Location: login.php");
  exit();
}

// Get employee information from the database
// Replace the database credentials and table/column names with your own
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the employee's username
$username = $_SESSION['username'];

// Get the employee's department and position from the database
$sql = "SELECT department, position FROM employees WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output employee information
  $row = $result->fetch_assoc();
  $department = $row["department"];
  $position = $row["position"];
  
  echo "Welcome, $username!<br>";
  echo "Department: $department<br>";
  echo "Position: $position<br>";
  
} else {
  echo "Error: Employee not found in the database.";
}

// Close connection
$conn->close();
?>
