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

// Check if vacancy ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare SQL query to delete vacancy
    $sql = "DELETE FROM vacancies WHERE id = $id";

    // Execute SQL query
    if ($conn->query($sql) === TRUE) {
        echo "Vacancy deleted successfully";
        header('Location: vacancies.php');
        exit;
    } else {
        echo "Error deleting vacancy: " . $conn->error;
        header('Location: vacancies.php');
        exit;
    }
} else {
    echo "Vacancy ID is not provided";
    header('Location: vacancies.php');
    exit;
}

// Close database connection
$conn->close();

?>
