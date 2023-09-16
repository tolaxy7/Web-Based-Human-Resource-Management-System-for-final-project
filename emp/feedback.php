<?php
include 'header.html';
// Assuming you have established a database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hrms';

// Establish a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check if user is logged in
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $feedback_type = $_POST["feedback_type"];
    $feedback_text = $_POST["feedback_text"];

    // Retrieve the employee_id from the employees table
    $employee_id = null;
    $sql = "SELECT id FROM employees WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $employee_id = $row["id"];
    }
    $stmt->close();

    if ($employee_id !== null) {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO feedback (employee_id, feedback_type, feedback_text) VALUES (?, ?, ?)");

        // Bind the parameters
        $stmt->bind_param("iss", $employee_id, $feedback_type, $feedback_text);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Feedback sent successfully!";
        } else {
            echo "Error sending feedback: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Employee ID not found.";
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
   <link rel="stylesheet" href="style/feedback1.css">
</head>
<body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="feedbackForm">
        <label for="feedback_type">Feedback Type:</label>
        <input type="text" name="feedback_type" id="feedback_type" required maxlength="100"><br><br>

        <label for="feedback_text">Feedback Text:</label><br>
        <textarea name="feedback_text" id="feedback_text" rows="5" cols="40" required></textarea><br><br>

        <input type="submit" value="Submit Feedback">
    </form>

    <script>
        document.getElementById("feedbackForm").addEventListener("submit", function(event) {
            var feedbackTypeInput = document.getElementById("feedback_type");
            var feedbackTextInput = document.getElementById("feedback_text");

            var maxFeedbackTypeLength = 100;
            var maxFeedbackTextLength = 2000;

            var errorMessages = [];

            // Feedback Type validation
            if (feedbackTypeInput.value.length > maxFeedbackTypeLength) {
                errorMessages.push("Feedback Type must not exceed " + maxFeedbackTypeLength + " characters");
            }

            // Feedback Text validation
            if (feedbackTextInput.value.length > maxFeedbackTextLength) {
                errorMessages.push("Feedback Text must not exceed " + maxFeedbackTextLength + " characters");
            }

            // Display error messages if any
            if (errorMessages.length > 0) {
                event.preventDefault(); // Prevent form submission

                // Display error messages as pop-up alerts
                alert("Please fix the following errors:\n\n" + errorMessages.join("\n"));

                // Highlight the input fields with errors
                if (errorMessages.includes("Feedback Type must not exceed " + maxFeedbackTypeLength + " characters")) {
                    feedbackTypeInput.classList.add("error");
                } else {
                    feedbackTypeInput.classList.remove("error");
                }

                if (errorMessages.includes("Feedback Text must not exceed " + maxFeedbackTextLength + " characters")) {
                    feedbackTextInput.classList.add("error");
                } else {
                    feedbackTextInput.classList.remove("error");
                }
            }
        });
    </script>
</body>
</html>
