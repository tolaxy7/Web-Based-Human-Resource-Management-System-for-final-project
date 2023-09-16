<?php
$host = "localhost";
$dbname = "hrms";
$user = "root";
$password = "";

// Establish a connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

// Execute a query to select all users
$sql = "SELECT * FROM users";
$stmt = $pdo->query($sql);

// Fetch the results as an associative array
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display the results in a table
echo "<table>";
echo "<tr><th>ID</th><th>Username</th><th>Role</th></tr>";
foreach ($results as $row) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['username']}</td>";
    echo "<td>{$row['role']}</td>";
    echo "</tr>";
}
echo "</table>";
?>
