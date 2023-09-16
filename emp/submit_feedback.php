<?php
    // Connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hrms";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve feedback data from form
    $employee_id = $_POST["employee_id"];
    $feedback_type = $_POST["feedback_type"];
    $feedback_text = $_POST["feedback_text"];

    // Retrieve sender's employee ID from employees table
    $user_id = $_SESSION["id"];
    $sql = "SELECT id FROM employees WHERE id = '$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        echo "Error: Employee ID not found.";
    } else {
        $row = $result->fetch_assoc();
        $sender_id = $row["id"];

        // Insert feedback into database
        $sql = "INSERT INTO feedback (employee_id, feedback_type, feedback_text) VALUES ('$sender_id', '$feedback_type', '$feedback_text')";
        if ($conn->query($sql) === TRUE) {
            echo "Feedback submitted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close database connection
    $conn->close();
?>