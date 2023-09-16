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
if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
    // Get input values
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate password
    if ($password !== $confirmPassword) {
        $error_message = "Passwords do not match.";
    } elseif (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d).+$/', $password)) {
        $error_message = "Password should contain at least one letter and one number.";
    } else {
        // Hash the password using MD5 (Not recommended)
        $hashedPassword = md5($password);

        // Get user ID from session
        $userId = $_SESSION['user_id'];

        // Update the password in the database
        $updateQuery = "UPDATE users SET password = '$hashedPassword' WHERE id = $userId";
        if (mysqli_query($conn, $updateQuery)) {
            // Password updated successfully, redirect to login page
            header("Location: login.php");
            exit;
        } else {
            $error_message = "Error updating password. Please try again.";
        }
    }
}

// Close database connection
mysqli_close($conn);
?>

?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/reset_password.css">
    <style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
  margin: 0;
  padding: 0;
}

h1 {
  text-align: center;
  margin-top: 30px;
}

.container {
  max-width: 400px;
  margin: 0 auto;
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  margin-top: 50px;
}

.error,
.success {
  color: #fff;
  background-color: #ff0000;
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 5px;
}

.success {
  background-color: #008000;
}

form {
  margin-top: 20px;
}

label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
  margin-bottom: 10px;
}

input[type="submit"] {
  width: 100%;
  padding: 10px;
  background-color: #4caf50;
  border: none;
  color: #fff;
  cursor: pointer;
  border-radius: 3px;
}

input[type="submit"]:hover {
  background-color: #45a049;
}


    </style>
</head>
<body>
    <h1>Reset Password</h1>
    <div class="container">
        <?php if (isset($error_message)) { ?>
            <div class="error">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php } elseif (isset($success_message)) { ?>
            <div class="success">
                <p><?php echo $success_message; ?></p>
            </div>
        <?php } ?>
        <form method="post">
            <label for="password">New Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <input type="submit" value="Reset Password">
        </form>
    </div>
</body>
</html>
