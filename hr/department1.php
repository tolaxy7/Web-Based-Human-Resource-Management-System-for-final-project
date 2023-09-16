<?php
// Start the session
session_start();

// Include config file
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'hrms';
$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Define variables and initialize with empty values
$name = "";
$manager = "";
$name_err = "";
$manager_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a department name.";
    } else {
        $name = $input_name;
    }

    // Validate manager
    $input_manager = trim($_POST["manager"]);
    if (empty($input_manager)) {
        $manager_err = "Please select a manager.";
    } else {
        $manager = $input_manager;
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($manager_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO departments (name, manager) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_name, $param_manager);

            // Set parameters
            $param_name = $name;
            $param_manager = $manager;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: departments.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
} elseif (isset($_GET["delete"]) && isset($_GET["id"])) {
    // Get URL parameters
    $id = $_GET["id"];

    // Prepare a delete statement
    $sql = "DELETE FROM departments WHERE id = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = $id;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Records deleted successfully. Redirect to landing page
            header("location: departments.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a department name.";
    } else {
        $name = $input_name;
    }

    // Validate manager
    $input_manager = trim($_POST["manager"]);
    if (empty($input_manager)) {
        $manager_err = "Please select a manager.";
    } else {
        $manager = $input_manager;
    }

    // Check input errors before updating in database
    if (empty($name_err) && empty($manager_err)) {
      // Prepare an update statement
      $sql = "UPDATE departments SET name=?, manager=? WHERE id=?";    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sii", $param_name, $param_manager, $param_id);

        // Set parameters
        $param_name = $name;
        $param_manager = $manager;
        $param_id = $_POST["id"];

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Records updated successfully. Redirect to landing page
            header("location: departments.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn);
} else {
    // Display error messages
    echo "Please fix the following errors:<br>";
    echo "- " . $name_err . "<br>";
    echo "- " . $manager_err . "<br>";
}
} else {
  // Check if the id parameter is set and valid
  if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
  // Prepare a select statement
  $sql = "SELECT * FROM departments WHERE id = ?";    if ($stmt = mysqli_prepare($conn, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);

    // Set parameters
    $param_id = $_GET["id"];

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            // Fetch the result row as an associative array
            $row = mysqli_fetch_assoc($result);

            // Retrieve individual field values
            $name = $row["name"];
            $manager = $row["manager"];
        } else {
            // URL doesn't contain valid id parameter. Redirect to error page
            header("location: error.php");
            exit();
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}

// Close statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($conn);
} else {
// URL doesn't contain id parameter. Redirect to error page
header("location: error.php");
exit();
}
}?>