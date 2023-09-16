<?php
// Include database configuration file
require_once 'db_connect.php';

// Check if schedule ID is provided
if (isset($_GET['id'])) {
    $scheduleId = $_GET['id'];

    // Fetch the schedule and employee details from the database
    $sql = "SELECT schedules.*, employees.name AS employee_name FROM schedules INNER JOIN employees ON schedules.employee_id = employees.id WHERE schedules.id = $scheduleId";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $employeeName = $row['employee_name'];
        $day = $row['day'];
        $startTime = $row['start_time'];
        $endTime = $row['end_time'];
    } else {
        // Redirect to the view schedules page if no schedule is found
        header("Location: view.php");
        exit();
    }
} else {
    // Redirect to the view schedules page if no schedule ID is provided
    header("Location: view.php");
    exit();
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Schedule</title>
    <link rel="stylesheet" type="text/css" href="css/scheduleedit.css">
    <style>
        /* scheduleedit.css */

        body {
          font-family: Arial, sans-serif;
          margin: 0;
          padding: 20px;
        }

        h1 {
          text-align: center;
        }

        form {
          max-width: 400px;
          margin: 20px auto;
          padding: 20px;
          border: 1px solid #ddd;
          border-radius: 5px;
          background-color: #f9f9f9;
        }

        label {
          display: block;
          margin-bottom: 10px;
          font-weight: bold;
        }

        input[type="text"] {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 4px;
        }
        input[type="time"] {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 4px;
        }
        input[type="submit"] {
          width: 100%;
          padding: 10px;
          background-color: #4CAF50;
          color: white;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'header.html'; ?>
    <h1>Edit Schedule</h1>
    <form method="post" action="">
        <label for="employee_name">Employee Name:</label>
        <input type="text" id="employee_name" name="employee_name" value="<?php echo $employeeName; ?>" readonly>
        <label for="day">Day:</label>
        <input type="text" id="day" name="day" value="<?php echo $day; ?>" required>
        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" value="<?php echo $startTime; ?>" required>
        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" value="<?php echo $endTime; ?>" required>
        <input type="submit" value="Update Schedule">
    </form>

    <script>
    function validateForm() {
        var day = document.getElementById("day").value;

        var errors = [];

        // Validate day
        if (day.trim() === "") {
            errors.push("Day is required.");
        } else if (day.length < 6 || day.length > 8) {
            errors.push("Day must be between 6 and 8 characters long.");
        }

        // Display errors or submit form
        if (errors.length > 0) {
            var errorContainer = document.getElementById("error-container");
            errorContainer.innerHTML = "";
            for (var i = 0; i < errors.length; i++) {
                var errorElement = document.createElement("p");
                errorElement.className = "error";
                errorElement.innerHTML = errors[i];
                errorContainer.appendChild(errorElement);
            }
            return false;
        } else {
            return true;
        }
    }
</script>

</body>
</html>
