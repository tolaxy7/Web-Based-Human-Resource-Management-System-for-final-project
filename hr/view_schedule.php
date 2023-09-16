<?php

include 'header.html';
// Connect to database
$host = 'localhost';
$db = 'hrms';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Retrieve data from schedules table
$stmt = $pdo->query("SELECT * FROM schedules");

// Display data in HTML table
echo '<table class="schedule-table">';
echo '<thead><tr><th>ID</th><th>Employee ID</th><th>Day</th><th>Start Time</th><th>End Time</th></tr></thead>';
echo '<tbody>';
while ($row = $stmt->fetch()) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['employee_id']."</td>";
    echo "<td>".$row['day']."</td>";
    echo "<td>".$row['start_time']."</td>";
    echo "<td>".$row['end_time']."</td>";
    echo "</tr>";
}
echo "</tbody></table>";
?>
<head>
    <link rel="stylesheet" href="css/viewvacancy.css">
</head>