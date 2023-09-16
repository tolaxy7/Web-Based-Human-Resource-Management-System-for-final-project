<?php
include 'header.html';
// Connect to database
$conn = new mysqli("localhost", "root", "", "hrms");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query departments table to get department options
$department_options = "";
$sql = "SELECT id, name FROM departments";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $department_options .= "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
  }
}

// Query positions table to get position options
$position_options = "";
$sql = "SELECT id, name FROM positions";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $position_options .= "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
  }
}

// If form is submitted
if(isset($_POST["submit"])) {
  // Get form data
  $username = $_POST["username"];
  $password = md5($_POST["password"]);
  $role = $_POST["role"];
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $department_id = $_POST["department"];
  $position_id = $_POST["position"];

  // Insert new user into users table
  $sql = "INSERT INTO users (username, password, role, first_name, last_name, email, phone, department, position) VALUES ('$username', '$password', '$role', '$first_name', '$last_name', '$email', '$phone', '$department_id', '$position_id')";
  if ($conn->query($sql) === TRUE) {
    echo "New user account created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Close database connection
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
  <script>
    function validateForm() {
      // Get form fields
      var username = document.getElementById('username').value;
      var password = document.getElementById('password').value;
      var role = document.getElementById('role').value;
      var firstName = document.getElementById('first_name').value;
      var lastName = document.getElementById('last_name').value;
      var email = document.getElementById('email').value;
      var phone = document.getElementById('phone').value;
      var department = document.getElementById('department').value;
      var position = document.getElementById('position').value;

      // Validate username (non-empty, unique, and format)
      if (username.trim() === '') {
        alert('Please enter a username.');
        return false;
      }
      if (!validateUsername(username)) {
        alert('Username should be at least 6 characters long and contain only letters, numbers, and underscores.');
        return false;
      }

      // Validate password (non-empty, strength, and not common)
      if (password.trim() === '') {
        alert('Please enter a password.');
        return false;
      }
      if (!validatePassword(password)) {
        alert('Password should be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character. It should not be a common word or phrase.');
        return false;
      }

      // Validate role (non-empty)
      if (role.trim() === '') {
        alert('Please select a role.');
        return false;
      }

      // Validate first name (non-empty and format)
      if (firstName.trim() === '') {
        alert('Please enter your first name.');
        return false;
      }
      if (!validateName(firstName)) {
        alert('First name should be at least 2 characters long and cannot contain any special characters.');
        return false;
      }

      // Validate last name (non-empty and format)
      if (lastName.trim() === '') {
        alert('Please enter your last name.');
        return false;
      }
      if (!validateName(lastName)) {
        alert('Last name should be at least 2 characters long and cannot contain any special characters.');
        return false;
      }

      // Validate email (non-empty and format)
      if (email.trim() === '') {
        alert('Please enter your email.');
        return false;
      }
      if (!validateEmail(email)) {
        alert('Please enter a valid email address.');
        return false;
      }

      // Validate phone (non-empty and format)
      if (phone.trim() === '') {
        alert('Please enter your phone number.');
        return false;
      }
      if (!validatePhone(phone)) {
        alert('Please enter a valid phone number.');
        return false;
      }

      // Validate department (non-empty)
      if (department.trim() === '') {
        alert('Please select a department.');
        return false;
      }

      // Validate position (non-empty)
      if (position.trim() === '') {
        alert('Please select a position.');
        return false;
      }

      return true;
    }

    // Function to validate username format
    function validateUsername(username) {
      var regex = /^[a-zA-Z0-9_]{3,}$/;
      return regex.test(username);
    }

    // Function to validate password strength and common words/phrases
    function validatePassword(password) {
      // Check length and character requirements
      if (password.length < 8) {
        return false;
      }
      if (!/[A-Z]/.test(password)) {
        return false;
      }
      if (!/[a-z]/.test(password)) {
        return false;
      }
      if (!/[0-9]/.test(password)) {
        return false;
      }
      if (!/[^a-zA-Z0-9]/.test(password)) {
        return false;
      }

      // Check for common words/phrases (add more if needed)
      var commonWords = ['password', '12345678', 'qwertyui'];
      for (var i = 0; i < commonWords.length; i++) {
        if (password.toLowerCase().includes(commonWords[i])) {
          return false;
        }
      }

      return true;
    }

    // Function to validate name format
    function validateName(name) {
      var regex = /^[a-zA-Z]{2,}$/;
      return regex.test(name);
    }

    // Function to validate email format
    function validateEmail(email) {
      var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return regex.test(email);
    }

    // Function to validate phone format
    function validatePhone(phone) {
      var regex = /^\d{10}$/;
      return regex.test(phone);
    }
  </script>
  <style>
  body {font-family: Arial, sans-serif;font-size: 16px;}
  h1 {text-align: center;}
  form {display: grid;grid-template-columns: repeat(4, 1fr);grid-gap: 10px;max-width: 800px;margin: 0 auto;padding: 20px;}
  label {font-weight: bold;}
  input[type="text"],input[type="password"],input[type="email"],input[type="tel"],select {width: 100%;padding: 5px;border: 1px solid #ccc;border-radius: 4px;}button[type="submit"] {grid-column: 1 / span 4;margin-top: 10px;padding: 10px;background-color: #333;color: #fff;border: none;border-radius: 4px;cursor: pointer;}button[type="submit"]:hover {background-color: #555;}</style>
</head>
<body>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateForm();">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="role">Role:</label>
    <select id="role" name="role" required>
      <option value="">Select a role</option>
      <option value="admin">Admin</option>
      <option value="hr">Human Resource</option>
      <option value="employee">Employee</option>
    </select>

    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required>

    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="phone">Phone:</label>
    <input type="tel" id="phone" name="phone" required>

    <label for="department">Department:</label>
    <select id="department" name="department" required>
      <option value="">Select a department</option>
      <?php echo $department_options; ?>
    </select>

    <label for="position">Position:</label>
    <select id="position" name="position" required>
      <option value="">Select a position</option>
      <?php echo $position_options; ?>
    </select>

    <button type="submit" name="submit">Create Account</button>
  </form>
</body>
</html>
