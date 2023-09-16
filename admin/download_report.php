<?php
// Establish database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "hrms";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if report ID is provided
if (isset($_GET['report_id'])) {
    $report_id = $_GET['report_id'];

    // Retrieve report data from the database
    $query = "SELECT title, description, data FROM reports WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $report_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $title, $description, $data);

    if (mysqli_stmt_fetch($stmt)) {
        // Set the appropriate headers for the file download
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="report.txt"');

        // Create the content of the file
        $file_content = "Title: $title" . PHP_EOL;
        $file_content .= "Description: $description" . PHP_EOL;
        $file_content .= "Data: $data" . PHP_EOL;

        // Output the file content to the browser
        echo $file_content;
        exit;
    } else {
        // Report not found
        echo "Report not found.";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close database connection
mysqli_close($conn);
?>
