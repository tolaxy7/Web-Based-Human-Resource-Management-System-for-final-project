<?php

include 'header.html';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Establish database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "hrms";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user ID
$user_id = $_SESSION['user_id'];

// Retrieve user's security question from the database
$query = "SELECT * FROM security_questions WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);
$security_question = mysqli_fetch_assoc($result);

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get updated input values
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    // Update user's security question in the database
    if ($security_question) {
        // Security question already exists, update it
        $update_query = "UPDATE security_questions SET question='$question', answer='$answer' WHERE user_id='$user_id'";
    } else {
        // Security question doesn't exist, insert new record
        $update_query = "INSERT INTO security_questions (user_id, question, answer) VALUES ('$user_id', '$question', '$answer')";
    }

    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        // Security question updated successfully
        echo "Security question updated successfully.";
        // You can also redirect the user to a different page here if needed
    } else {
        // Error updating security question
        echo "Error updating security question: " . mysqli_error($conn);
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Security Question</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
}

form {
    background-color: #fff;
    width: 400px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

label {
    display: block;
    margin-bottom: 10px;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 10px;
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
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

.error-message {
    color: red;
    margin-top: 10px;
}

.success-message {
    color: green;
    margin-top: 10px;
}

    </style>
</head>
<body>
    <h1>Edit Security Question</h1>
    <form method="post" onsubmit="return validateForm()">
  <label for="question">Security Question:</label>
  <input type="text" id="question" name="question" value="<?php echo $security_question ? $security_question['question'] : ''; ?>" required>

  <label for="answer">Answer:</label>
  <input type="text" id="answer" name="answer" value="<?php echo $security_question ? $security_question['answer'] : ''; ?>" required>

  <input type="submit" name="submit" value="Save Changes">
</form>

<script>
  function validateForm() {
    var questionInput = document.getElementById('question');
    var answerInput = document.getElementById('answer');

    // Validate Security Question (Max 250 characters)
    if (questionInput.value.length > 250) {
      alert("Security Question can only have a maximum of 250 characters.");
      return false;
    }

    // Validate Answer (Max 100 characters)
    if (answerInput.value.length > 100) {
      alert("Answer can only have a maximum of 100 characters.");
      return false;
    }

    // Form is valid, allow submission
    return true;
  }
</script>

</body>
</html>
