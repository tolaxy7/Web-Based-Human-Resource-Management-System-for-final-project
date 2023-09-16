<?php
session_start();

// Establish database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "hrms";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Get input values
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the query using prepared statements
    $query = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) == 1) {
        // User exists, fetch user details
        mysqli_stmt_bind_result($stmt, $user_id, $username, $hashed_password, $role);
        mysqli_stmt_fetch($stmt);

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            session_regenerate_id(true); // Regenerate session ID
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['user_role'] = $role;

            // Redirect user to appropriate dashboard based on role
            if ($role == 'admin') {
                header("Location: admin/home.php");
            } elseif ($role == 'hr') {
                header("Location: hr/home.html");
            } else {
                header("Location: emp/home.php");
            }
            exit;
        } else {
            // Password is incorrect
            $error_message = "Invalid username or password.";
        }
    } else {
        // User does not exist
        $error_message = "Invalid username or password.";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        h1 {
            text-align: center;
            color: #555;
        }

        form {
            background-color: #fff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 3px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
