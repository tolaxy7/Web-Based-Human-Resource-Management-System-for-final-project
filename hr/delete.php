<?php

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=hrms', 'root', '');

// Get the employee ID from the URL
$id = $_GET['id'];

// Check if the employee exists
$sql = 'SELECT * FROM employees WHERE id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

// If the employee does not exist, redirect to the list of employees
if (!$employee) {
  header('Location: list.php');
  exit;
}

// Check if the employee is a department manager
$sql = 'SELECT * FROM departments WHERE manager = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$department = $stmt->fetch(PDO::FETCH_ASSOC);

// If the employee is a department manager, update the department with a new manager
if ($department) {
  // Set the department's manager ID to 0 temporarily
  $sql = 'UPDATE departments SET manager = 0 WHERE id = :departmentId';
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':departmentId', $department['id']);
  $stmt->execute();
}

// Delete the related feedback records for the employee
$sql = 'DELETE FROM feedback WHERE employee_id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// Delete the employee
$sql = 'DELETE FROM employees WHERE id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// Delete the related data (e.g., schedules) for the employee
$sql = 'DELETE FROM schedules WHERE employee_id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

// Redirect to the list of employees
header('Location: list.php');

// Close the database connection
$db = null;

?>
