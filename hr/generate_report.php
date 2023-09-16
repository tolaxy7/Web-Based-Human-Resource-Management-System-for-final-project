<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generate Report</title>
  <style>
    /* Global styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Table styles */
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
      margin-bottom: 20px;
    }

    th, td {
      text-align: left;
      padding: 8px;
      border: 1px solid #ddd;
    }

    th {
      background-color: #4CAF50;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    /* Submit button styles */
    input[type="submit"] {
      background-color: #4CAF50;
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      margin-top: 20px;
      cursor: pointer;
      border-radius: 4px;
    }

    input[type="submit"]:hover {
      background-color: #3e8e41;
    }
/* Style the form label */
form label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: bold;
}

/* Style the select dropdown */
form select {
  display: block;
  margin-bottom: 1rem;
  padding: 0.5rem;
  font-size: 1rem;
  border-radius: 0.25rem;
  border: 1px solid #ccc;
  width: 100%;
}

/* Style the submit button */
form input[type="submit"] {
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  cursor: pointer;
  font-size: 1rem;
}

/* Hide the feedback type dropdown by default */
#feedback_type_section {
  display: none;
}
    
  </style>
</head>
<body>
  <?php require 'header.html';?>

  <form method="post">
    <label for="report_type">Select report type:</label>
    <select name="report_type" id="report_type">
      <option value="">--Select report type--</option>
      <option value="salary">Salary</option>
      <option value="feedback">Feedback</option>
    </select>
    <br>
    <div id="feedback_type_section" style="display:none;">
      <label for="feedback_type">Select feedback type:</label>
      <select name="feedback_type" id="feedback_type">
        <option value="">--Select feedback type--</option>
        <?php
        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "hrms";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Fetch feedback types from the database
        $sql = "SELECT DISTINCT feedback_type FROM feedback";
        $result = $conn->query($sql);

        // Display feedback types in the dropdown
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['feedback_type'] . "'>" . $row['feedback_type'] . "</option>";
          }
        }

        // Close the database connection
        $conn->close();
        ?>
      </select>
    </div>
    <br>
    <input type="submit" value="Generate report">
  </form>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var report_type_select = document.getElementById("report_type");
      var feedback_type_section = document.getElementById("feedback_type_section");

      report_type_select.addEventListener("change", function() {
        if (report_type_select.value === "feedback") {
          feedback_type_section.style.display = "block";
        } else {
          feedback_type_section.style.display = "none";
        }
      });
    });
  </script>
</body>
</html>
<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrms";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the report type and feedback type from the user input
$report_type = isset($_POST["report_type"]) ? $_POST["report_type"] : '';
$feedback_type = isset($_POST["feedback_type"]) ? $_POST["feedback_type"] : '';

// Validate the report type
if ($report_type == "salary" || $report_type == "feedback") {

  // Query the appropriate table with the report type
  if ($report_type == "salary") {
    // Query the employees table for the salary report
    $sql = "SELECT name, department, position, salary FROM employees ORDER BY salary DESC";
  } else {
    // Query the feedback table for the feedback report
    // Validate the feedback type
    if (!empty($feedback_type)) {
      // Prepare the SQL statement with a parameterized query to avoid SQL injection
      $stmt = $conn->prepare("SELECT e.name, f.feedback_text FROM feedback f JOIN employees e ON f.employee_id = e.id WHERE f.feedback_type = ?");
      $stmt->bind_param("s", $feedback_type);
      $stmt->execute();
      $result = $stmt->get_result();
    } else {
      // Invalid feedback type
      echo "Please select a valid feedback type.";
      exit();
    }
  }

  // Execute the query
  if ($report_type == "salary") {
    $result = $conn->query($sql);
  }

  // Check if there are any records
  if ($result->num_rows > 0) {
    // Create a table to display the report
    echo "<table border='1'>";

    // Add the table headers based on the report type
    if ($report_type == "salary") {
      echo "<tr><th>Name</th><th>Department</th><th>Position</th><th>Salary</th></tr>";
    } else {
      echo "<tr><th>Name</th><th>Feedback Text</th></tr>";
    }

    // Loop through the records and display them in the table
    while ($row = $result->fetch_assoc()) {
      echo "<tr>";

      // Add the table data based on the report type
      if ($report_type == "salary") {
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["department"] . "</td>";
        echo "<td>" . $row["position"] . "</td>";
        echo "<td>" . $row["salary"] . "</td>";
      } else {
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["feedback_text"] . "</td>";
      }

      echo "</tr>";
    }

    echo "</table>";
  } else {
    // No records found
    echo "No records found.";
  }
} else {
  // Invalid report type
  echo "Please enter a valid report type: salary or feedback";
  exit();
}

// Close the database connection
$conn->close();
?>
