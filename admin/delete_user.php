<?php

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

// Get user ID from URL parameter
$user_id = $_GET['id'];

// Delete feedback associated with the employee first
$sqlFeedback = "DELETE FROM feedback WHERE employee_id IN (SELECT id FROM employees WHERE user_id = $user_id)";
if ($conn->query($sqlFeedback) === TRUE) {
    // Once feedback is deleted, delete the schedules associated with the employee
    $sqlSchedules = "DELETE FROM schedules WHERE employee_id IN (SELECT id FROM employees WHERE user_id = $user_id)";
    if ($conn->query($sqlSchedules) === TRUE) {
        // Once schedules are deleted, proceed to delete the employee and user
        $sqlEmployees = "DELETE FROM employees WHERE user_id = $user_id";
        if ($conn->query($sqlEmployees) === TRUE) {
            // Once employees are deleted, proceed to delete the user
            $sqlUsers = "DELETE FROM users WHERE id = $user_id";
            if ($conn->query($sqlUsers) === TRUE) {
                echo "User deleted successfully.";
            } else {
                echo "Error deleting user: " . $conn->error;
            }
        } else {
            echo "Error deleting employees: " . $conn->error;
        }
    } else {
        echo "Error deleting schedules: " . $conn->error;
    }
} else {
    echo "Error deleting feedback: " . $conn->error;
}

$conn->close();

?>