<?php include 'header.html'; ?> <br><br>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Generate Report</title>
  <style>
    body {
  font-family: "Helvetica", sans-serif;
}

form {
  width: 600px;
  margin: 0 auto;
}

label, select, input {
  display: block;
  margin-bottom: 10px;
}

#feedback_type_section {
  margin-left: 20px; 
}

table {
  width: 600px;
  margin: 20px auto;
  border-collapse: collapse;
}

th, td {
  padding: 10px;
  border: 1px solid #333;
}

th {
  background-color: #ddd;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
}
  </style>

</head>
<body>
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

    // Fetch the feedback types from the database
    $feedbackTypesSql = "SELECT DISTINCT feedback_type FROM feedback";
    $feedbackTypesResult = $conn->query($feedbackTypesSql);

    // Generate the options based on the fetched feedback types
    if ($feedbackTypesResult->num_rows > 0) {
      while ($row = $feedbackTypesResult->fetch_assoc()) {
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
    
    // Trigger the change event on page load if there is a selected report type
    if (report_type_select.value === "feedback") {
      feedback_type_section.style.display = "block";
    }
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
    // Query the employees table for salary report
    $sql = "SELECT name, department, position, salary FROM employees ORDER BY salary DESC";
  } else {
    // Query the feedback table for feedback report
    // Validate the feedback type
    if (!empty($feedback_type)) {
      // Query the feedback table with the feedback type
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
