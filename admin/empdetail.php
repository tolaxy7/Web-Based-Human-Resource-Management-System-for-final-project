<?php

include 'header.html';
// Connect to database
$host = 'localhost';
$dbname = 'hrms';
$username = 'root';
$password = '';

$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Retrieve employee records
$sql = "SELECT * FROM employees";
$stmt = $db->prepare($sql);
$stmt->execute();
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Management System</title>
    <link rel="stylesheet" href="css/empdetail.css">
</head>
<body>
    <h1>Employee Management System</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Position</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Salary</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
                <th>Country</th>
                <th>Emergency Contact Name</th>
                <th>Emergency Contact Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= htmlspecialchars($employee['name']) ?></td>
                    <td><?= htmlspecialchars($employee['email']) ?></td>
                    <td><?= htmlspecialchars($employee['phone']) ?></td>
                    <td><?= htmlspecialchars($employee['department']) ?></td>
                    <td><?= htmlspecialchars($employee['position']) ?></td>
                    <td><?= htmlspecialchars($employee['start_date']) ?></td>
                    <td><?= htmlspecialchars($employee['end_date']) ?></td>
                    <td><?= htmlspecialchars($employee['salary']) ?></td>
                    <td><?= htmlspecialchars($employee['gender']) ?></td>
                    <td><?= htmlspecialchars($employee['date_of_birth']) ?></td>
                    <td><?= htmlspecialchars($employee['address']) ?></td>
                    <td><?= htmlspecialchars($employee['city']) ?></td>
                    <td><?= htmlspecialchars($employee['state']) ?></td>
                    <td><?= htmlspecialchars($employee['zip']) ?></td>
                    <td><?= htmlspecialchars($employee['country']) ?></td>
                    <td><?= htmlspecialchars($employee['emergency_contact_name']) ?></td>
                    <td><?= htmlspecialchars($employee['emergency_contact_phone']) ?></td>
                    <td>
                        <a href="edit_employee.php?id=<?= $employee['id'] ?>">Edit</a>
                        <a href="delete_employee.php?id=<?= $employee['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="add_employee.php">Add Employee</a>
</body>
</html>
