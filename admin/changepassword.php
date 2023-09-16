<?php 
// Start or resume the session
session_start();
include 'header.html';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the submitted form data
    $existingPassword = md5($_POST['existing_password']);
    $newPassword = md5($_POST['new_password']);
    $confirmPassword = md5($_POST['confirm_password']);

    // Perform password change validation
    if (verifyExistingPassword($existingPassword)) {
        // Password change is valid, perform the necessary actions
        changePassword($newPassword);
        echo 'Password changed successfully.';
    } else {
        echo 'Invalid password change. Please try again.';
    }
}

// Function to verify the existing password
function verifyExistingPassword($existingPassword) {
    // Connect to the database
    $db = new PDO('mysql:host=localhost;dbname=hrms', 'root', '');

    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Prepare the SQL statement
    $sql = 'SELECT password FROM users WHERE id = :id';

    // Execute the SQL statement
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    // Fetch the password from the database
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Close the database connection
    $db = null;

    // Check if the password was found in the database
    if ($row && isset($row['password'])) {
        $userPassword = $row['password'];

        // Compare the existing password with the user's actual password
        if ($existingPassword === $userPassword) {
            return true;
        }
    }

    return false;
}

// Function to change the user's password
function changePassword($newPassword) {
    // Connect to the database
    $db = new PDO('mysql:host=localhost;dbname=hrms', 'root', '');

    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Prepare the SQL statement to update the password
    $sql = 'UPDATE users SET password = :password WHERE id = :id';

    // Execute the SQL statement
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':password', $newPassword);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    // Close the database connection
    $db = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Change Password</h1>

    <?php if (isset($_POST['submit']) && !verifyExistingPassword(md5($_POST['existing_password']))): ?>
    <?php endif; ?>

    <form method="POST">
        <label for="existing_password">Existing Password:</label>
        <input type="password" id="existing_password" name="existing_password" required>

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <button type="submit" name="submit">Change Password</button>
    </form>
    <script>
        // Password validation function
        function validatePassword() {
            var newPassword = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            // Use regex to check password strength
            var strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!strongPasswordRegex.test(newPassword)) {
                alert("Password must contain at least 8 characters, including at least one uppercase letter, one lowercase letter, one number, and one special symbol.");
                return false;
            }

            if (newPassword !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            return true;
        }

        // Add event listener to the form submit event
        var form = document.querySelector("form");
        form.addEventListener("submit", function(event) {
            if (!validatePassword()) {
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
</body>
</html>
