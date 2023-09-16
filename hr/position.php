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

// Add a position
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_position"])) {
    $positionName = $_POST["position_name"];
    $description = $_POST["description"];
    $salaryRange = $_POST["salary_range"];

    $sql = "INSERT INTO positions (name, description, salary_range) VALUES ('$positionName', '$description', '$salaryRange')";
    if (mysqli_query($conn, $sql)) {
        echo "Position added successfully.";
    } else {
        echo "Error adding position: " . mysqli_error($conn);
    }
}

// Update a position
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_position"])) {
    $positionId = $_POST["position_id"];
    $positionName = $_POST["position_name"];
    $description = $_POST["description"];
    $salaryRange = $_POST["salary_range"];

    $sql = "UPDATE positions SET name = '$positionName', description = '$description', salary_range = '$salaryRange' WHERE id = $positionId";
    if (mysqli_query($conn, $sql)) {
        echo "Position updated successfully.";
    } else {
        echo "Error updating position: " . mysqli_error($conn);
    }
}

// Delete a position
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_position"])) {
    $positionId = $_POST["position_id"];

    $sql = "DELETE FROM positions WHERE id = $positionId";
    if (mysqli_query($conn, $sql)) {
        echo "Position deleted successfully.";
    } else {
        echo "Error deleting position: " . mysqli_error($conn);
    }
}

// Fetch existing positions
$sql = "SELECT * FROM positions";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Position Management</title><style>
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
    select,
    textarea {
        width: 200px;
        padding: 5px;
        margin-bottom: 10px;
    }

    input[type="submit"],
    input[type="reset"],
    input[type="button"] {
        padding: 5px 10px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        cursor: pointer;
    }

    input[type="submit"]:hover,
    input[type="reset"]:hover,
    input[type="button"]:hover {
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

    /* Two-column layout */
    .container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-gap: 20px;
    }

    /* Form section */
    .form-section {
        grid-column: 1 / span 1;
    }

    /* Table section */
    .table-section {
        grid-column: 2 / span 1;
    }

    /* Additional styles for table */
    table {
        border-collapse: collapse;
        margin-bottom: 20px;
        width: 100%;
    }

    table, th, td {
        border: 1px solid black;
        padding: 5px;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Styling for update and delete buttons */
    .update-button,
    .delete-button {
        background-color: #008CBA;
        margin-right: 5px;
    }

    .update-button:hover,
    .delete-button:hover {
        background-color: #006080;
    }
</style>

<body>
    <h2>Add Position</h2>
    <form id="position_form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="position_name">Position Name:</label>
        <input type="text" id="position_name" name="position_name" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="salary_range">Salary Range:</label>
        <input type="text" id="salary_range" name="salary_range" required><br>

        <input type="submit" value="Add Position" name="add_position">
    </form>

    <script>
  document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('position_form');
    form.addEventListener('submit', function(event) {
      var positionNameInput = document.getElementById('position_name');
      var descriptionInput = document.getElementById('description');
      var salaryRangeInput = document.getElementById('salary_range');

      var positionName = positionNameInput.value.trim();
      var description = descriptionInput.value.trim();
      var salaryRange = salaryRangeInput.value.trim();

      var positionNamePattern = /^[a-zA-Z ]{4,40}$/;
      var descriptionPattern = /^[a-zA-Z ]{4,500}$/;
      var salaryRangePattern = /^\d{4,40}(\.\d{1,2})?$/;

      var isValid = true;

      if (!positionNamePattern.test(positionName)) {
        positionNameInput.classList.add('error');
        isValid = false;
      } else {
        positionNameInput.classList.remove('error');
      }

      if (!descriptionPattern.test(description)) {
        descriptionInput.classList.add('error');
        isValid = false;
      } else {
        descriptionInput.classList.remove('error');
      }

      if (!salaryRangePattern.test(salaryRange)) {
        salaryRangeInput.classList.add('error');
        isValid = false;
      } else {
        salaryRangeInput.classList.remove('error');
      }

      if (!isValid) {
        event.preventDefault();
      }
    });
  });
</script>


    <h2>Update Position</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="update_position_form">
        <label for="position_id">Position:</label>
        <select id="position_id" name="position_id" required>
            <option value="">--Select Position--</option>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
            }
            ?>
        </select><br>

        <label for="position_name">Position Name:</label>
        <input type="text" id="position_name" name="position_name" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="salary_range">Salary Range:</label>
        <input type="text" id="salary_range" name="salary_range" required><br>

        <input type="submit" value="Update Position" name="update_position">
    </form>
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    var updateForm = document.getElementById('update_position_form');
    updateForm.addEventListener('submit', function(event) {
      var positionNameInput = document.getElementById('position_name');
      var descriptionInput = document.getElementById('description');
      var salaryRangeInput = document.getElementById('salary_range');

      var positionName = positionNameInput.value.trim();
      var description = descriptionInput.value.trim();
      var salaryRange = salaryRangeInput.value.trim();

      var positionNamePattern = /^[a-zA-Z ]{4,40}$/;
      var descriptionPattern = /^[a-zA-Z ]{4,500}$/;
      var salaryRangePattern = /^\d{4,40}(\.\d{1,2})?$/;

      var isValid = true;

      if (!positionNamePattern.test(positionName)) {
        alert('Position Name: Please enter only alphabetic characters, minimum 4 and maximum 40 characters.');
        isValid = false;
      }

      if (!descriptionPattern.test(description)) {
        alert('Description: Please enter only alphabetic characters, minimum 4 and maximum 500 characters.');
        isValid = false;
      }

      if (!salaryRangePattern.test(salaryRange)) {
        alert('Salary Range: Please enter a valid number with up to 2 decimal places, minimum 4 and maximum 40 characters.');
        isValid = false;
      }

      if (!isValid) {
        event.preventDefault();
      }
    });

    var deleteForm = document.getElementById('delete_position_form');
    deleteForm.addEventListener('submit', function(event) {
      var positionIdInput = document.getElementById('position_id');

      if (positionIdInput.value === '') {
        alert('Please select a position.');
        event.preventDefault();
      }
    });
  });
</script>


    <h2>Delete Position</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="delete_position_form">
        <label for="position_id">Position:</label>
        <select id="position_id" name="position_id" required>
            <option value="">--Select Position--</option>
            <?php
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Delete Position" name="delete_position">
    </form>

    <h2>Existing Positions</h2>
    <table>
        <tr>
            <th>Position Name</th>
            <th>Description</th>
            <th>Salary Range</th>
        </tr>
        <?php
        mysqli_data_seek($result, 0);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "<td>" . $row["salary_range"] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    mysqli_close($conn);
    ?>
</body>
</html>
