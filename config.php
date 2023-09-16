<?php
// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'hrms');

// Connect to the database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            }

            th, td {
            text-align: left;
            padding: 8px;
            }

            th {
            background-color: #4285F4;
            color: #fff;
            }

            tr:nth-child(even) {
            background-color: #f2f2f2;
            }

            tr:hover {
            background-color: #ddd;
            }

    </style>
</head>