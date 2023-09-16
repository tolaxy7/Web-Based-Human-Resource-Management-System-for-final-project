<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/vacancy.css">
    <style>
        /* Custom CSS for the vacancies table */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .vacancy-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .vacancy-table th,
        .vacancy-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        
        .vacancy-table th {
            background-color: #f2f2f2;
        }
        
        .vacancy-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .vacancy-table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <?php include('header.html'); ?>
    
    <div class="container">
        <?php
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

        // Retrieve data from vacancies table
        $stmt = $pdo->query("SELECT * FROM vacancies");

        // Display data in HTML table
        echo "<table class='vacancy-table'>";
        echo "<tr><th>ID</th><th>Title</th><th>Description</th><th>Department</th><th>Position</th><th>Salary</th><th>Start Date</th><th>End Date</th></tr>";
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>".$row['id']."</td>";
            echo "<td>".$row['title']."</td>";
            echo "<td>".$row['description']."</td>";
            echo "<td>".$row['department']."</td>";
            echo "<td>".$row['position']."</td>";
            echo "<td>".$row['salary']."</td>";
            echo "<td>".$row['start_date']."</td>";
            echo "<td>".$row['end_date']."</td>";
            echo "</tr>";
        }
        echo "</table>";

        ?>
    </div>
</body>
</html>
