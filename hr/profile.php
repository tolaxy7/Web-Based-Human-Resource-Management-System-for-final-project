<?php
// Start session
session_start();

// Include database connection file
include 'db_connect.php';
include 'header.html';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header('Location: ../login.php');
  exit;
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Check if form is submitted
if (isset($_POST['submit'])) {
  // Get form data
  $username = $_POST['username'];
  $password = $_POST['password'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $department = $_POST['department'];
  $position = $_POST['position'];

  // Check if a profile picture is uploaded
  if (!empty($_FILES['profile_picture']['name'])) {
    $profile_picture = addslashes(file_get_contents($_FILES['profile_picture']['tmp_name']));
    $profile_picture_type = $_FILES['profile_picture']['type'];

    // Check if the uploaded file is an image
    if ($profile_picture_type == 'image/jpeg' || $profile_picture_type == 'image/png') {
      // Update user profile with profile picture
      $sql = "UPDATE users SET username = '$username', password = '$password', first_name = '$first_name', last_name = '$last_name', email = '$email', phone = '$phone', department = '$department', position = '$position', profile_picture = '$profile_picture' WHERE id = $user_id";
      $result = $conn->query($sql);
    } else {
      // Redirect to profile page with error message if the uploaded file is not an image
      header('Location: profile.php?message=Error+updating+record:+Invalid+image+file.');
      exit;
    }
  } else {
    // Update user profile without profile picture
    $sql = "UPDATE users SET username = '$username', password = '$password', first_name = '$first_name', last_name = '$last_name', email = '$email', phone = '$phone', department = '$department', position = '$position' WHERE id = $user_id";
    $result = $conn->query($sql);
  }

  // Check if update is successful
  if ($result) {
    // Redirect to profile page with success message
    header('Location: profile.php?message=Profile+updated+successfully.');
    exit;
  } else {
    // Redirect to profile page with error message
    header('Location: profile.php?message=Error+updating+record:+'.urlencode($conn->error));
    exit;
  }
}

// Get user profile data
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

// Check if user profile exists
if ($result->num_rows > 0) {
  // Get user profile data
  $row = $result->fetch_assoc();
  $username = $row['username'];
 
  $first_name = $row['first_name'];
  $last_name = $row['last_name'];
  $email = $row['email'];
  $phone = $row['phone'];

  // Display edit profile form
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <style>
      /* profile.css */

/* Profile picture styling */
.profile-picture {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
}

.profile-picture img {
  border-radius: 50%;
  width: 200px;
  height: 200px;
  object-fit: cover;
  object-position: center;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}

/* profile.css */

/* Form styling */
form {
  max-width: 800px; /* Adjust the max-width as needed */
  margin: 40px auto; /* Adjust the margin value as needed */
  padding: 20px;
  background-color: #f9f9f9;
  border: 1px solid #ddd;
  border-radius: 5px;
  display: flex; /* Use flexbox to display form inputs in columns */
  flex-wrap: wrap; /* Allow form inputs to wrap to the next row */
  justify-content: center; /* Center the columns horizontally */
}

/* Column styling */
.column {
  flex: 1 1 22%; /* Make columns equal in width and allow for some spacing between them */
  padding: 10px;
  box-sizing: border-box;
  margin: 10px;
}

/* Label styling */
label {
  display: block;
  margin-bottom: 5px;
}

/* Input styling */
input[type="text"],
input[type="password"],
input[type="email"],
input[type="tel"] {
  width: 100%;
  padding: 5px;
  margin-bottom: 10px;
  box-sizing: border-box;
}

input[type="file"] {
  margin-top: 10px;
}

/* Submit button styling */
input[type="submit"] {
  display: block;
  width: 100%;
  padding: 10px;
  margin-top: 10px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

/* Error message styling */
.error-message {
  color: red;
  margin-top: 10px;
}a.button-link {
  display: inline-block;
  padding: 8px;
  background-color: #4CAF50;
  color: white;
  text-decoration: none;
  margin-right: 8px;
}

a.button-link:hover {
  background-color: #3e8e41;
}

.button-link button {
  border: none;
  background: none;
  padding: 0;
  font: inherit;
  cursor: pointer;
  outline: inherit;
}

    </style>
  </head>
  <body>

  <a href="edit_security.php" class="button-link"><button>edit security question</button></a>
  <a href="changepassword.php" class="button-link"><button>change password</button></a>

  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" id="employeeForm">
    <div class="profile-picture">
      <div id="errorContainer" class="error-message"></div>
      <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($row['profile_picture']); ?>" alt="Profile Picture">
    </div>

    <div class="column">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" value="<?php echo $username; ?>" required>
    </div>

    

    <div class="column">
      <label for="first_name">First Name:</label>
      <input type="text" name="first_name" id="first_name" value="<?php echo $first_name; ?>" required>
    </div>

    <div class="column">
      <label for="last_name">Last Name:</label>
      <input type="text" name="last_name" id="last_name" value="<?php echo $last_name; ?>" required>
    </div>

    <div class="column">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" value="<?php echo $email; ?>" required>
    </div>

    <div class="column">
      <label for="phone">Phone:</label>
      <input type="tel" name="phone" id="phone" value="<?php echo $phone; ?>" required>
    </div>

    <div class="column">
      <label for="profile_picture">Profile Picture:</label>
      <input type="file" name="profile_picture" id="profile_picture">
    </div>

    <div class="column">
      <input type="submit" name="submit" value="Update Profile">
    </div>
  </form>

  <script>
    // Form validation logic
    document.getElementById("employeeForm").addEventListener("submit", function(event) {
      var usernameInput = document.getElementById("username");
      var passwordInput = document.getElementById("password");
      var firstNameInput = document.getElementById("first_name");
      var lastNameInput = document.getElementById("last_name");
      var emailInput = document.getElementById("email");
      var phoneInput = document.getElementById("phone");
      var departmentInput = document.getElementById("department");
      var positionInput = document.getElementById("position");

      var namePattern = /^[A-Za-z\s]+$/; // Alphabetic characters and spaces only
      var usernamePattern = /^[A-Za-z0-9_]+$/; // Alphanumeric characters and underscore only
      var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/; // At least 8 characters, one uppercase letter, one lowercase letter, and one digit
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Email pattern
      var phonePattern = /^\d{10}$/; // 10-digit phone number pattern

      var errorMessages = [];

      // Username validation
      if (!usernamePattern.test(usernameInput.value)) {
        errorMessages.push("Username must contain only alphanumeric characters and underscore");
        usernameInput.classList.add("error");
      } else {
        usernameInput.classList.remove("error");
      }

      // Password validation
      if (!passwordPattern.test(passwordInput.value)) {
        errorMessages.push("Password must be at least 8 characters long and contain one uppercase letter, one lowercase letter, and one digit");
        passwordInput.classList.add("error");
      } else {
        passwordInput.classList.remove("error");
      }

      // First name validation
      if (!namePattern.test(firstNameInput.value)) {
        errorMessages.push("First name must contain only alphabetic characters");
        firstNameInput.classList.add("error");
      } else {
        firstNameInput.classList.remove("error");
      }

      // Last name validation
      if (!namePattern.test(lastNameInput.value)) {
        errorMessages.push("Last name must contain only alphabetic characters");
        lastNameInput.classList.add("error");
      } else {
        lastNameInput.classList.remove("error");
      }

      // Email validation
      if (!emailPattern.test(emailInput.value)) {
        errorMessages.push("Invalid email format");
        emailInput.classList.add("error");
      } else {
        emailInput.classList.remove("error");
      }

      // Phone number validation
      if (!phonePattern.test(phoneInput.value)) {
        errorMessages.push("Phone number must be a 10-digit number");
        phoneInput.classList.add("error");
      } else {
        phoneInput.classList.remove("error");
      }

    
      // Display error messages if any
      var errorContainer = document.getElementById("errorContainer");
      if (errorMessages.length > 0) {
        event.preventDefault(); // Prevent form submission

        // Clear previous error messages
        while (errorContainer.firstChild) {
          errorContainer.removeChild(errorContainer.firstChild);
        }

        // Display new error messages
        for (var i = 0; i < errorMessages.length; i++) {
          var errorMessage = document.createElement("p");
          errorMessage.textContent = errorMessages[i];
          errorContainer.appendChild(errorMessage);
        }
      } else {
        // Clear previous error messages
        while (errorContainer.firstChild) {
          errorContainer.removeChild(errorContainer.firstChild);
        }
      }
    });
  </script>
</body>
</html>

<?php
} else {
  // Redirect to login page if user profile does not exist
  header('Location: ../login.php');
  exit;
}
?>