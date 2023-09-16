<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the user has added a security question
$user_id = $_SESSION['user_id'];

// Establish database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "hrms";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM security_questions WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    // User has added a security question
    $user = mysqli_fetch_assoc($result);
    $question = $user['question'];
    $answer = $user['answer'];

    // Redirect user to appropriate dashboard based on role
    $query = "SELECT role FROM users WHERE id='$user_id'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user['role'] == 'admin') {
        header("Location: admin/home.php");
    } elseif ($user['role'] == 'hr') {
        header("Location: hr/home.php");
    } else {
        header("Location: emp/home.php");
    }
    exit;
}

// Process the form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    // Insert the security question and answer into the database
    $insertQuery = "INSERT INTO security_questions (user_id, question, answer) VALUES ('$user_id', '$question', '$answer')";
    if (mysqli_query($conn, $insertQuery)) {
        // Redirect user to appropriate dashboard based on role
        $roleQuery = "SELECT role FROM users WHERE id='$user_id'";
        $roleResult = mysqli_query($conn, $roleQuery);
        $user = mysqli_fetch_assoc($roleResult);

        if ($user['role'] == 'admin') {
            header("Location: admin/home.php");
        } elseif ($user['role'] == 'hr') {
            header("Location: hr/home.php");
        } else {
            header("Location: emp/home.php");
        }
        exit;
    } else {
        echo "Error inserting data into the database: " . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Security Question</title>
    <style>
        body {
            background-image: url("images/hrms.avif");
            background-size: cover;
            background-position: center;
        }

        h1 {
            color: #fff;
            text-align: center;
            margin-top: 50px;
        }

        form {
            background-color: rgba(255, 255, 255, 0.8);
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        form label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-top: 10px;
        }

        form input[type="text"],
        form input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        form p.error-message {
            color: red;
            margin-top: 10px;
        }

        form .register-link {
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <h1>Add Security Question</h1>
    <form method="post">
        <label for="question">Security Question:</label>
        <input type="text" id="question" name="question" required>

        <label for="answer">Answer:</label>
        <input type="text" id="answer" name="answer" required>

        <input type="submit" value="Add Question">
    </form>
</body>
</html>
