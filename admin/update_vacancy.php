<?php

include 'header.html';
// Connect to database
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'hrms';
$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Update record in database
    $sql = "UPDATE vacancies SET title='$title', description='$description', department='$department', position='$position', salary='$salary', start_date='$start_date', end_date='$end_date' WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: vacancies.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Get vacancy data from database
    $id = $_GET['id'];
    $sql = "SELECT * FROM vacancies WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $title = $row['title'];
        $description = $row['description'];
        $department = $row['department'];
        $position = $row['position'];
        $salary = $row['salary'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
    } else {
        echo "No vacancy found with ID $id";
        exit();
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Vacancy</title>
    <link rel="stylesheet" type="text/css" href="css/update.css">
    <script type="text/javascript">
        function validateForm() {
            // Get form values
            var title = document.forms["updateForm"]["title"].value;
            var description = document.forms["updateForm"]["description"].value;
            var department = document.forms["updateForm"]["department"].value;
            var position = document.forms["updateForm"]["position"].value;
            var salary = document.forms["updateForm"]["salary"].value;

            // Define regular expressions for validation
            var characterPattern = /^[\s\S]+$/;
            var salaryPattern = /^\d{4,10}$/;

            // Title validation
            if (!characterPattern.test(title) || title.length < 5 || title.length > 100) {
                alert("Title should contain any character and have a length between 5 and 100 characters.");
                return false;
            }

            // Description validation
            if (!characterPattern.test(description) || description.length < 20 || description.length > 500) {
                alert("Description should contain any character and have a length between 20 and 500 characters.");
                return false;
            }

            // Department validation
            if (!characterPattern.test(department) || department.length < 2 || department.length > 100) {
                alert("Department should contain any character and have a length between 2 and 100 characters.");
                return false;
            }

            // Position validation
            if (!characterPattern.test(position) || position.length < 4 || position.length > 100) {
                alert("Position should contain any character and have a length between 4 and 100 characters.");
                return false;
            }

            // Salary validation
            if (!salaryPattern.test(salary)) {
                alert("Salary should contain only digits and have a length between 4 and 10 characters.");
                return false;
            }

            return true;
        }
    </script>

    <style>
        input[type="submit"] {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 12px 24px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 8px;
}
    </style>
</head>
<body>
    <h1>Update Vacancy</h1>
    <form name="updateForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateForm()">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo $title; ?>" required>
        <br>
        <label>Description:</label>
        <textarea name="description"><?php echo $description; ?></textarea>
        <br>
        <label>Department:</label>
        <input type="text" name="department" value="<?php echo $department; ?>" required>
        <br>
        <label>Position:</label>
        <input type="text" name="position" value="<?php echo $position; ?>" required>
        <br>
        <label>Salary:</label>
        <input type="text" name="salary" value="<?php echo $salary; ?>" required>
        <br>
        <label>Start Date:</label>
        <input type="date" name="start_date" value="<?php echo $start_date; ?>" required>
        <br>
        <label>End Date:</label>
        <input type="date" name="end_date" value="<?php echo $end_date; ?>" required>
        <br>
        <input type="submit" value="Update">

        
    </form>
</body>
</html>
