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
    $password = md5($_POST['password']);

    // Check if the user exists and get user details
    $query = "SELECT id, username, role FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // User exists, set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_role'] = $user['role'];

        // Redirect user to add_security_question.php
        header("Location: add_security_question.php");
        exit;
    } else {
        // User does not exist, show error message
        $error_message = "Invalid username or password.";
    }
}

// Close database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <style>
    body {
    background-image: url("path/to/background-image.jpg");
    background-size: cover;
    background-position: center;
}

h1 {
    color: #fff;
    text-align: center;
    margin-top: 50px;
}

.login-container {
    background-color: rgba(255, 255, 255, 0.8);
    width: 300px;
    margin: 0 auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    text-align: center;
}

.login-container label {
    display: block;
    text-align: left;
    font-weight: bold;
    margin-top: 10px;
}

.login-container input[type="text"],
.login-container input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 5px;
}

.login-container input[type="submit"] {
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

.login-container input[type="submit"]:hover {
    background-color: #45a049;
}

.login-container p.error-message {
    color: red;
    margin-top: 10px;
}

.login-container .forgot-password {
    margin-top: 10px;
}

.login-container .social-login {
    margin-top: 20px;
}

.login-container .social-login a {
    display: inline-block;
    margin-right: 10px;
}

.login-container .register-link {
    margin-top: 20px;
}

.error {
    color: red;
    margin-top: 5px;
    font-size: 14px;
}

#runaway-btn {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 12px 24px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 4px;
}

#runaway-btn:hover {
  background-color: #3e8e41;
}
</style>
</head>
<body>
    <h1>Login</h1>
    <div class="login-container">
        <?php if (isset($error_message)) { ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="post" onsubmit="return validateForm();">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button id="runaway-btn" type="submit">login</button>
            
            <p class="forgot-password"><a href="forgot.php">Forgot password?</a></p>
            
            <div class="social-login">
                <a href="#"><img src="images/facebook-icon.png" alt="Facebook" style="width: 30px; height: 30px;"></a>
                <a href="#"><img src="images/google-icon..png" alt="Google" style="width: 30px; height: 30px;"></a>
                <a href="#"><img src="images/twitter-icon..png" alt="Twitter" style="width: 30px; height: 30px;"></a>
            </div>

        </form>
    </div>

    <script>
        function moveLoginButton() {
  var passwordInput = document.getElementById("password");
  var loginBtn = document.getElementById("runaway-btn");
  var containerWidth = document.getElementsByClassName("login-container")[0].offsetWidth;
  var containerHeight = document.getElementsByClassName("login-container")[0].offsetHeight;
  var maxX = containerWidth - loginBtn.offsetWidth;
  var maxY = containerHeight - loginBtn.offsetHeight;

  if (passwordInput.value.length < 8) {
    var xPos = Math.floor(Math.random() * maxX);
    var yPos = Math.floor(Math.random() * maxY);
    loginBtn.style.transform = `translate(${xPos}px, ${yPos}px)`;
  } else {
    loginBtn.style.transform = `translate(0, 0)`;
  }
}

document.addEventListener("DOMContentLoaded", function() {
  var loginBtn = document.getElementById("runaway-btn");
  loginBtn.addEventListener("mouseover", moveLoginButton);
});

    </script>
</body>
</html>
