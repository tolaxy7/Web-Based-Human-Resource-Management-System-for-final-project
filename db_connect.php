<?php
$servername = "localhost"; // assuming the MySQL server is on the same machine as the PHP script
$username = "root";
$password = ""; // if you set a password for the root user, replace the empty string with the actual password
$dbname = "hrms";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*echo "Connected successfully to database " . $dbname;*/
?>
