<?php
// Assuming you have already established a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrms";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the employee ID
$employeeId = $_GET['id']; // You can replace $_GET['id'] with the appropriate variable containing the employee ID

// Delete the schedules associated with the employee
$deleteSql = "DELETE FROM schedules WHERE employee_id = $employeeId";

if ($conn->query($deleteSql) === TRUE) {
    // Schedules deleted successfully, proceed with deleting the employee
    $deleteEmployeeSql = "DELETE FROM employees WHERE id = $employeeId";

    if ($conn->query($deleteEmployeeSql) === TRUE) {
        // Employee and associated schedules deleted successfully, redirect to employee detail page
        header("Location: empdetail.php?id=$employeeId");
        exit;
    } else {
        echo "Error deleting employee: " . $conn->error;
    }
} else {
    echo "Error deleting schedules: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
