<?php
// Connect to database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'hrms';
$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get employee ID from URL parameter
$id = $_GET['id'];

// Get employee name from database
$sql = "SELECT * FROM employees WHERE id='$id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $employee_name = $row['first_name'] . ' ' . $row['last_name'];
} else {
    echo "No employee found with ID $id";
    exit();
}

// Get employee schedule from database
$sql = "SELECT * FROM schedules WHERE employee_id='$id'";
$result = mysqli_query($conn, $sql);
$schedules = array();
while ($row = mysqli_fetch_assoc($result)) {
    $schedules[$row['day']] = array(
        'start_time' => $row['start_time'],
        'end_time' => $row['end_time']
    );
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Schedule - <?php echo $employee_name; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>View Schedule - <?php echo $employee_name; ?></h1>
    <table>
        <tr>
            <th>Day</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        <?php
        $days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        foreach ($days as $day) {
            echo "<tr>";
            echo "<td>$day</td>";
            if (isset($schedules[$day])) {
                $start_time = date('h:i A', strtotime($schedules[$day]['start_time']));
                $end_time = date('h:i A', strtotime($schedules[$day]['end_time']));
                echo "<td>$start_time</td>";
                echo "<td>$end_time</td>";
            } else {
                echo "<td colspan=\"2\">No schedule</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
