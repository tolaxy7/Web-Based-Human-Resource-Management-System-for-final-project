<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: forgot_password.php");
    exit;
}

// Retrieve user ID from the session
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

// Retrieve security question for the user from the database
$query = "SELECT question FROM security_questions WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$security_question = mysqli_fetch_assoc($result);

// Check if form is submitted (security question answer)
if (isset($_POST['answer'])) {
    // Get input value
    $answer = $_POST['answer'];

    // Retrieve security answer from the database for the user
    $query = "SELECT answer FROM security_questions WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $query);
    $security_answer = mysqli_fetch_assoc($result);

    if ($security_answer && $security_answer['answer'] === $answer) {
        // Security answer is correct, allow the user to reset the password
        header("Location: reset_password.php");
        exit;
    } else {
        // Security answer is incorrect
        $error_message = "Invalid security answer. Please try again.";
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Security Question</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }
        
        h1 {
            text-align: center;
            margin-top: 50px;
        }
        
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
        }
        
        input[type="submit"] {
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
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h1>Security Question</h1>
    <div class="container">
        <div class="message">
            <?php if (isset($error_message)) { ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php } ?>
        </div>
        <form method="post">
            <label for="answer"><?php echo $security_question ? $security_question['question'] : ''; ?></label>
            <input type="text" id="answer" name="answer" required>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
