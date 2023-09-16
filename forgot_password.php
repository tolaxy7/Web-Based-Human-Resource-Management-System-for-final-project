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

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    // User is already logged in, redirect to the password reset page
    header("Location: reset_password.php");
    exit;
}

// Check if form is submitted (security question answer)
if (isset($_POST['answer'])) {
    // Get input value
    $answer = $_POST['answer'];

    // Retrieve user ID from the session
    $user_id = $_SESSION['user_id'];

    // Check if the answer matches the stored answer in the database
    $query = "SELECT id FROM security_questions WHERE user_id='$user_id' AND answer='$answer'";
    $result = mysqli_query($conn, $query);
    $security_question = mysqli_fetch_assoc($result);

    if ($security_question) {
        // Answer is correct, store user ID in session and redirect to the password reset page
        $_SESSION['user_id'] = $security_question['id'];
        header("Location: reset_password.php");
        exit;
    } else {
        // Answer is incorrect, show error message
        $error_message = "Incorrect answer. Please try again.";
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Forgot Password</h1>
    <div class="message">
        <?php if (isset($error_message)) { ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php } ?>
    </div>
    <form method="post">
        <label for="answer">Answer:</label>
        <input type="text" id="answer" name="answer" required>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
