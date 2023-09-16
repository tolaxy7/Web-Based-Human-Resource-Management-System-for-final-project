<?php
include 'header.html';

// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrms";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to fetch employee details by ID
function getEmployeeById($employeeId, $conn) {
    $sql = "SELECT * FROM employees WHERE id = $employeeId";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

// Add a department
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_department"])) {
    $departmentName = $_POST["department_name"];
    $managerId = $_POST["manager_id"];

    $sql = "INSERT INTO departments (name, manager) VALUES ('$departmentName', $managerId)";
    if (mysqli_query($conn, $sql)) {
        echo "Department added successfully.";
    } else {
        echo "Error adding department: " . mysqli_error($conn);
    }
}

// Update a department
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_department"])) {
    $departmentId = $_POST["department_id"];
    $departmentName = $_POST["department_name"];
    $managerId = $_POST["manager_id"];

    $sql = "UPDATE departments SET name = '$departmentName', manager = $managerId WHERE id = $departmentId";
    if (mysqli_query($conn, $sql)) {
        echo "Department updated successfully.";
    } else {
        echo "Error updating department: " . mysqli_error($conn);
    }
}

// Delete a department
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_department"])) {
    $departmentId = $_POST["department_id"];

    $sql = "DELETE FROM departments WHERE id = $departmentId";
    if (mysqli_query($conn, $sql)) {
        echo "Department deleted successfully.";
    } else {
        echo "Error deleting department: " . mysqli_error($conn);
    }
}

// Fetch employees for manager dropdown
$sql = "SELECT id, name FROM employees";
$employeesResult = mysqli_query($conn, $sql);

// Fetch existing departments
$sql = "SELECT d.id, d.name AS department_name, e.name AS manager_name FROM departments d
        INNER JOIN employees e ON d.manager = e.id";
$departmentsResult = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Department Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 200px;
            padding: 5px;
            margin-bottom: 10px;
        }

        input[type="submit"],
        input[type="reset"] {
            padding: 5px 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        .success {
            color: green;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Additional styles for displaying existing departments */
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Add Department</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" onsubmit="return validateForm()">
    <label for="department_name">Department Name:</label>
    <input type="text" id="department_name" name="department_name" required><br>

    <label for="manager_id">Manager:</label>
    <select id="manager_id" name="manager_id" required>
        <option value="">--Select Manager--</option>
        <?php
        while ($row = mysqli_fetch_assoc($employeesResult)) {
            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
        }
        ?>
    </select><br>

    <input type="submit" value="Add Department" name="add_department">
</form>

<script>
    function validateForm() {
        var departmentName = document.getElementById("department_name").value;
        
        // Regular expression to match only characters
        var regex = /^[A-Za-z]+$/;
        
        // Check if the department name meets the length requirements and contains only characters
        if (departmentName.length < 2 || departmentName.length > 40 || !regex.test(departmentName)) {
            alert("Department Name must contain only characters and be between 2 and 40 characters long.");
            return false; // Prevent form submission
        }
        
        return true; // Allow form submission
    }
</script>


    <h2>Update Department</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="department_id">Department:</label>
        <select id="department_id" name="department_id" required>
            <option value="">--Select Department--</option>
            <?php
            mysqli_data_seek($departmentsResult, 0);
            while ($row = mysqli_fetch_assoc($departmentsResult)) {
                echo "<option value='" . $row["id"] . "'>" . $row["department_name"] . "</option>";
            }
            ?>
        </select><br>

        <label for="department_name">Department Name:</label>
        <input type="text" id="department_name" name="department_name" required><br>

        <label for="manager_id">Manager:</label>
        <select id="manager_id" name="manager_id" required>
            <option value="">--Select Manager--</option>
            <?php
            mysqli_data_seek($employeesResult, 0);
            while ($row = mysqli_fetch_assoc($employeesResult)) {
                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Update Department" name="update_department">
    </form>

    <h2>Delete Department</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="department_id">Department:</label>
        <select id="department_id" name="department_id" required>
            <option value="">--Select Department--</option>
            <?php
            mysqli_data_seek($departmentsResult, 0);
            while ($row = mysqli_fetch_assoc($departmentsResult)) {
                echo "<option value='" . $row["id"] . "'>" . $row["department_name"] . "</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Delete Department" name="delete_department">
    </form>

    <h2>Existing Departments</h2>
    <table>
        <tr>
            <th>Department Name</th>
            <th>Manager</th>
        </tr>
        <?php
        mysqli_data_seek($departmentsResult, 0);
        while ($row = mysqli_fetch_assoc($departmentsResult)) {
            echo "<tr>";
            echo "<td>" . $row["department_name"] . "</td>";
            echo "<td>" . $row["manager_name"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <script src="js/emp.manage.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>
