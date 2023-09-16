<?php
// Include config file
require_once "config.php";

// Define query to select all vacancies
$sql = "SELECT * FROM vacancies";

// Execute query and store result
$result = $mysqli->query($sql);

// Check if query was successful
if ($result) {
    // Check if any vacancies were found
    if ($result->num_rows > 0) {
        // Output table header
        echo "<table>";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Title</th>";
        echo "<th>Description</th>";
        echo "<th>Department</th>";
        echo "<th>Position</th>";
        echo "<th>Salary</th>";
        echo "<th>Start Date</th>";
        echo "<th>End Date</th>";
        echo "</tr>";

        // Output table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "<td>" . $row["department"] . "</td>";
            echo "<td>" . $row["position"] . "</td>";
            echo "<td>" . $row["salary"] . "</td>";
            echo "<td>" . $row["start_date"] . "</td>";
            echo "<td>" . $row["end_date"] . "</td>";
            echo "</tr>";
        }

        // Output table footer
        echo "</table>";
    } else {
        // No vacancies found
        echo "No vacancies found.";
    }
} else {
    // Query failed
    echo "Error: " . $mysqli->error;
}

// Close connection
$mysqli->close();
?>
