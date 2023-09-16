<?php
include('header.html');
// Connect to database
$host = 'localhost';
$db   = 'hrms';
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

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $employee_id = $_POST['employee_id'];
    $day = $_POST['day'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    
    // Insert or update schedule data into schedules table
    $stmt = $pdo->prepare("SELECT id FROM schedules WHERE employee_id = ? AND day = ?");
    $stmt->execute([$employee_id, $day]);
    $schedule_id = $stmt->fetchColumn();
    
    if ($schedule_id) {
        $stmt = $pdo->prepare("UPDATE schedules SET start_time = ?, end_time = ? WHERE id = ?");
        $stmt->execute([$start_time, $end_time, $schedule_id]);
        echo "Schedule updated successfully";
    } else {
        $stmt = $pdo->prepare("INSERT INTO schedules (employee_id, day, start_time, end_time) VALUES (?, ?, ?, ?)");
        $stmt->execute([$employee_id, $day, $start_time, $end_time]);
        echo "Schedule added successfully";
    }
}

// Get list of employees
$stmt = $pdo->prepare("SELECT id, name FROM employees ORDER BY name ASC");
$stmt->execute();
$employees = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/schedule.css">
  <style>
    body {
  font-family: Arial, sans-serif;
  font-size: 16px;
  background-color: #f0f0f0;
}

.schedule-form {
  margin: 100px auto;
  max-width: 400px;
  background-color: #fff;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.schedule-form label {
  display: inline-block;
  width: 120px;
  text-align: right;
  margin-right: 20px;
}

.schedule-form select,
.schedule-form input[type="time"],
.schedule-form input[type="submit"] {
  width: 200px;
  margin-bottom: 10px;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
}

.schedule-form input[type="submit"] {
  background-color: #4CAF50;
  color: #fff;
  cursor: pointer;
}

.schedule-form a {
  display: inline-block;
  padding: 10px;
  background-color: #4CAF50;
  color: #fff;
  text-decoration: none;
  margin-top: 20px;
  border-radius: 4px;
}

.schedule-form a:hover {
  background-color: #3e8e41;
}

  </style>
</head>
<body>
  <form method="post" class="schedule-form">
  <label for="employee_id">Employee:</label>
  <select id="employee_id" name="employee_id">
    <?php foreach ($employees as $employee) { ?>
      <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
    <?php } ?>
  </select><br>

  <label for="day">Day:</label>
  <select id="day" name="day">
    <option value="Monday">Monday</option>
    <option value="Tuesday">Tuesday</option>
    <option value="Wednesday">Wednesday</option>
    <option value="Thursday">Thursday</option>
    <option value="Friday">Friday</option>
    <option value="Saturday">Saturday</option>
    <option value="Sunday">Sunday</option>
  </select><br>

  <label for="start_time">Start Time:</label>
  <input type="time" id="start_time" name="start_time" required><br>

  <label for="end_time">End Time:</label>
  <input type="time" id="end_time" name="end_time" required><br>

  <input type="submit" value="Submit">
</form>
<a href="view_schedule.php">show schedule</a>
</body>
</html>