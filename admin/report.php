<?php
include 'header.html';
// Establish database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "hrms";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve existing reports from the database
$query = "SELECT id, title FROM reports";
$result = mysqli_query($conn, $query);

// Check if there are any reports
if (mysqli_num_rows($result) > 0) {
    // Display the list of reports
    echo "<div id=\"report-list\">";
    echo "<h2>Available Reports:</h2>";
    echo "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        $report_id = $row['id'];
        $report_title = $row['title'];
        echo "<li><a href=\"download_report.php?report_id=$report_id\">$report_title</a></li>";
    }
    echo "</ul>";
    echo "</div>";
} else {
    echo "No reports found.";
}

// Close database connection
mysqli_close($conn);
?>
<head>
    <style>
        #report-list {
  background-color: #f1f1f1;
  padding: 20px;
}

#report-list h2 {
  color: #555;
}

#report-list ul {
  list-style-type: none;
  padding: 0;
}

#report-list li {
  margin-bottom: 10px;
}

#report-list li a {
  text-decoration: none;
  color: #333;
}

#report-list li a:hover {
  color: #4CAF50;
}

    </style>
</head>