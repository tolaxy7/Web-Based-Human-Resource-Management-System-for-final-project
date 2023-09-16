<?php
// Include database configuration file
require_once 'db_connect.php';

// Check if schedule ID is provided
if (isset($_GET['id'])) {
    $scheduleId = $_GET['id'];

    // Delete the schedule from the database
    $sql = "DELETE FROM schedules WHERE id = $scheduleId";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Redirect to the view schedules page after successful deletion
        header("Location: scheduleview.php");
        exit();
    } else {
        // Handle the case when deletion fails
        echo "Error deleting schedule: " . mysqli_error($conn);
    }
} else {
    // Redirect to the view schedules page if no schedule ID is provided
    header("Location: view.php");
    exit();
}

// Close database connection
mysqli_close($conn);
?>
