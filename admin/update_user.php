<?php
require 'header.html';

// Function to sanitize user input
function sanitizeInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hrms";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind parameters
    $stmt = $conn->prepare("UPDATE users SET username=?, password=?, role=?, first_name=?, last_name=?, email=?, phone=?, department=?, position=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $username, $password, $role, $first_name, $last_name, $email, $phone, $department, $position, $id);

    // Set parameters from form data
    $id = $_POST["id"];
    $username = sanitizeInput($_POST["username"]);
    $role = sanitizeInput($_POST["role"]);
    $first_name = sanitizeInput($_POST["first_name"]);
    $last_name = sanitizeInput($_POST["last_name"]);
    $email = sanitizeInput($_POST["email"]);
    $phone = sanitizeInput($_POST["phone"]);
    $department = sanitizeInput($_POST["department"]);
    $position = sanitizeInput($_POST["position"]);

    // Execute statement and check for errors
    if ($stmt->execute()) {
        echo "User updated successfully";
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();

} else {

    // Connect to database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hrms";
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get user data from database
    $id = $_GET["id"];
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    // Fetch position options from the database
    $position_options = "";
    $sql = "SELECT * FROM positions";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($position_row = $result->fetch_assoc()) {
            $position_options .= '<option value="' . $position_row["id"] . '"';
            if ($row["id"] == $position_row["id"]) {
                $position_options .= ' selected';
            }
            $position_options .= '>' . $position_row["name"] . '</option>';
        }
    }

    // Fetch department options from the database
    $department_options = "";
    $sql = "SELECT * FROM departments";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($department_row = $result->fetch_assoc()) {
            $department_options .= '<option value="' . $department_row["id"] . '"';
            if ($row["id"] == $department_row["id"]) {
                $department_options .= ' selected';
            }
            $department_options .= '>' . $department_row["name"] . '</option>';
        }
    }

    // Close database connection
    $conn->close();

    // Display HTML form with user data
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Update User</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 16px;
            }

            h2 {
                text-align: center;
            }

            form {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                grid-gap: 10px;
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }

            label {
                font-weight: bold;
            }

            input[type="text"],
            input[type="password"],
            input[type="email"],
            input[type="tel"],
            select {
                width: 100%;
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            input[type="submit"] {
                grid-column: 1 / span 4;
                margin-top: 10px;
                padding: 10px;
                background-color: #333;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            input[type="submit"]:hover {
                background-color: #555;
            }

            .error {
                color: red;
            }
        </style>
        <script>
    function validateForm() {
        var username = document.getElementById("username").value;
        var firstName = document.getElementById("first_name").value;
        var lastName = document.getElementById("last_name").value;
        var email = document.getElementById("email").value;
        var phone = document.getElementById("phone").value;

        var errors = [];

        // Validate username
        if (username.trim() === "") {
            errors.push("Username is required.");
        } else if (username.length < 3 || username.length > 50) {
            errors.push("Username must be between 3 and 50 characters long.");
        } else if (!/^[a-zA-Z0-9]+$/.test(username)) {
            errors.push("Username can only contain letters and numbers.");
        }

        // Validate first name
        if (firstName.trim() === "") {
            errors.push("First Name is required.");
        } else if (firstName.length < 3 || firstName.length > 10) {
            errors.push("First Name must be between 3 and 10 characters long.");
        } else if (!/^[a-zA-Z]+$/.test(firstName)) {
            errors.push("First Name can only contain letters.");
        }

        // Validate last name
        if (lastName.trim() === "") {
            errors.push("Last Name is required.");
        } else if (lastName.length < 3 || lastName.length > 10) {
            errors.push("Last Name must be between 3 and 10 characters long.");
        } else if (!/^[a-zA-Z]+$/.test(lastName)) {
            errors.push("Last Name can only contain letters.");
        }

        // Validate email
        if (email.trim() === "") {
            errors.push("Email is required.");
        } else if (!/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/.test(email)) {
            errors.push("Email is not valid.");
        }

        // Validate phone number
        if (phone.trim() === "") {
            errors.push("Phone number is required.");
        } else if (!/^09\d{8}$/.test(phone)) {
            errors.push("Phone number is not valid. It should start with '09' and have 10 digits.");
        }

        // Display errors or submit form
        if (errors.length > 0) {
            var errorContainer = document.getElementById("error-container");
            errorContainer.innerHTML = "";
            for (var i = 0; i < errors.length; i++) {
                var errorElement = document.createElement("p");
                errorElement.className = "error";
                errorElement.innerHTML = errors[i];
                errorContainer.appendChild(errorElement);
            }
            return false;
        } else {
            return true;
        }
    }
</script>

    </head>
    <body>
    <h2>Update User:</h2>
    <form
        method="post"
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
        onsubmit="return validateForm()"
    >
        <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $row["username"]; ?>" required>
        
        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="">Select a role</option>
            <option value="admin" <?php if ($row["role"] == "admin") echo "selected"; ?>>Admin</option>
            <option value="hr" <?php if ($row["role"] == "hr") echo "selected"; ?>>HR</option>
            <option value="employee" <?php if ($row["role"] == "employee") echo "selected"; ?>>Employee</option>
        </select>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo $row["first_name"]; ?>" required>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo $row["last_name"]; ?>" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $row["email"]; ?>" required>
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $row["phone"]; ?>" required>
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
        <input type="submit" value="Update User">
        <div id="error-container"></div>
    </form>
    </body>
    </html>
    <?php
}
?>
