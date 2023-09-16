<?php
session_start();
include 'header.html';
// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Include your database credentials and establish a connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrms";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success_message = "";
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $employee_id = $_POST["employee_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $department = $_POST["department"];
    $position = $_POST["position"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $salary = $_POST["salary"];
    $gender = $_POST["gender"];
    $date_of_birth = $_POST["date_of_birth"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $country = $_POST["country"];
    $emergency_contact_name = $_POST["emergency_contact_name"];
    $emergency_contact_phone = $_POST["emergency_contact_phone"];

    // Update the employee details in the database
    $sql = "UPDATE employees SET name = '$name', email = '$email', phone = '$phone', department = '$department',
        position = '$position', start_date = '$start_date', end_date = '$end_date', salary = '$salary',
        gender = '$gender', date_of_birth = '$date_of_birth', address = '$address', city = '$city', state = '$state',
        zip = '$zip', country = '$country', emergency_contact_name = '$emergency_contact_name',
        emergency_contact_phone = '$emergency_contact_phone' WHERE id = '$employee_id'";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Employee details updated successfully!";
    } else {
        $error_message = "Error updating employee details: " . $conn->error;
    }
}

// Fetch the employee details from the database
$employee_id = $_SESSION["user_id"];
$sql = "SELECT * FROM employees WHERE user_id = '$employee_id'";
$result = $conn->query($sql);

// Check if the employee record exists
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $name = $row["name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $department = $row["department"];
    $position = $row["position"];
    $start_date = $row["start_date"];
    $end_date = $row["end_date"];
    $salary = $row["salary"];
    $gender = $row["gender"];
    $date_of_birth = $row["date_of_birth"];
    $address = $row["address"];
    $city = $row["city"];
    $state = $row["state"];
    $zip = $row["zip"];
    $country = $row["country"];
    $emergency_contact_name = $row["emergency_contact_name"];
    $emergency_contact_phone = $row["emergency_contact_phone"];
} else {
    $error_message = "Employee record not found.";
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee Details</title>
    <style>
       .container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 10px;
}

.container label {
    display: block;
    font-weight: bold;
}

.container input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box; /* Added to include padding and border in the width calculation */
}

.container input[type="submit"] {
    width: auto;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    cursor: pointer;
}

.container p {
    color: red;
    font-weight: bold;
}

.success-message {
    color: green;
    font-weight: bold;
}


    </style>
</head>
<body>
    <h2>Edit Employee Details</h2>

    <?php if (!empty($error_message)) : ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if (!empty($success_message)) : ?>
        <p class="success-message"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if ($result->num_rows == 1) : ?>
      <form id="myForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return validateForm();"> 
      <div class="container">
                <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $name; ?>">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" value="<?php echo $department; ?>" readonly>

                <label for="position">Position:</label>
                <input type="text" id="position" name="position" value="<?php echo $position; ?>" readonly>
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
                <label for="salary">Salary:</label>
                <input type="number" id="salary" name="salary" value="<?php echo $salary; ?>">
                <label for="gender">Gender:</label>
                <input type="text" id="gender" name="gender" value="<?php echo $gender; ?>">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $date_of_birth; ?>">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo $city; ?>">
                <label for="state">State:</label>
                <input type="text" id="state" name="state" value="<?php echo $state; ?>">
                <label for="zip">ZIP:</label>
                <input type="text" id="zip" name="zip" value="<?php echo $zip; ?>">
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" value="<?php echo $country; ?>">
                <label for="emergency_contact_name">Emergency Contact Name:</label>
                <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo $emergency_contact_name; ?>">
                <label for="emergency_contact_phone">Emergency Contact Phone:</label>
                <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo $emergency_contact_phone; ?>">
            </div>
            <input type="submit" value="Update" style="width: auto; padding: 10px 20px; background-color: #4CAF50; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
   
          </form>
        <script>
  function validateForm() {
    // Define your custom validation rules here
    var validationRules = {
      name: { required: true, maxLength: 255 },
      email: { required: true, email: true },
      phone: { required: true, phone: true },
      salary: { required: true, number: true },
      gender: { required: true, validGender: true },
      date_of_birth: { required: true, validDate: true },
      address: { required: true, validAddress: true },
      city: { required: true, validCity: true },
      state: { required: true, validState: true },
      zip: { required: true, validZIP: true },
      country: { required: true, validCountry: true },
      emergency_contact_name: { required: true, validName: true },
      emergency_contact_phone: { required: true, phone: true },
    };

    // Perform validation based on the defined rules
    var formElements = document.getElementById("myForm").elements;
    var isValid = true;

    for (var i = 0; i < formElements.length; i++) {
      var element = formElements[i];
      var fieldName = element.name;
      var fieldValue = element.value;
      var rules = validationRules[fieldName];

      if (rules && rules.required && fieldValue.trim() === "") {
        alert("Please fill out all required fields.");
        isValid = false;
        break;
      }

      if (rules && rules.maxLength && fieldValue.length > rules.maxLength) {
        alert(fieldName + " should not exceed " + rules.maxLength + " characters.");
        isValid = false;
        break;
      }

      if (rules && rules.email && !validateEmail(fieldValue)) {
        alert("Please enter a valid email address for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.phone && !validatePhone(fieldValue)) {
        alert("Please enter a valid phone number for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.number && isNaN(fieldValue)) {
        alert("Please enter a valid number for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.validGender && !validateGender(fieldValue)) {
        alert("Please enter a valid gender (male, female, or other) for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.validDate && !validateDate(fieldValue)) {
        alert("Please enter a valid date for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.validAddress && !validateAddress(fieldValue)) {
        alert("Please enter a valid address for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.validCity && !validateCity(fieldValue)) {
        alert("Please enter a valid city for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.validState && !validateState(fieldValue)) {
        alert("Please enter a valid state for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.validZIP && !validateZIP(fieldValue)) {
        alert("Please enter a valid ZIP code for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.validCountry && !validateCountry(fieldValue)) {
        alert("Please enter a valid country for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.validName && !validateName(fieldValue)) {
        alert("Please enter a valid name for " + fieldName + ".");
        isValid = false;
        break;
      }

      if (rules && rules.validEmergencyContactPhone && !validateEmergencyContactPhone(fieldValue)) {
        alert("Please enter a valid phone number for emergency contact phone.");
        isValid = false;
        break;
      }
    }

    return isValid;
  }

  function validateEmail(email) {
    // Email validation logic
    var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return email.match(emailRegex);
  }

  function validatePhone(phone) {
    // Phone number validation logic
    var phoneRegex = /^\d{10}$/;
    return phone.match(phoneRegex);
  }

  function validateGender(gender) {
    // Gender validation logic
    var validGenders = ["male", "female", "other"];
    return validGenders.includes(gender.toLowerCase());
  }

  function validateDate(date) {
    // Date validation logic
    var dobDate = new Date(date);
    return !isNaN(dobDate.getTime());
  }

  function validateAddress(address) {
    // Address validation logic
    // Customize this function according to your validation requirements
    var addressRegex = /^[A-Za-z0-9\s]+$/;
    return address.match(addressRegex);
  }

  function validateCity(city) {
    // City validation logic
    // Customize this function according to your validation requirements
    var cityRegex = /^[A-Za-z\s]+$/;
    return city.match(cityRegex);
  }

  function validateState(state) {
    // State validation logic
    // Customize this function according to your validation requirements
    var stateRegex = /^[A-Za-z\s]+$/;
    return state.match(stateRegex);
  }

  function validateZIP(zip) {
    // ZIP validation logic
    // Customize this function according to your validation requirements
    var zipRegex = /^\d{5}$/;
    return zip.match(zipRegex) || zip === "0000";
  }

  function validateCountry(country) {
    // Country validation logic
    // Customize this function according to your validation requirements
    var countryRegex = /^[A-Za-z\s]+$/;
    return country.match(countryRegex);
  }


  function validateName(name) {
        var nameRegex = /^[A-Za-z\s]+$/;
        return name.match(nameRegex) && !/\d/.test(name);
    }

  function validateEmergencyContactPhone(phone) {
    // Emergency contact phone validation logic
    // Customize this function according to your validation requirements
    var phoneRegex = /^\d{10}$/;
    return phone.match(phoneRegex);
  }

  
</script>

<script>
function validateForm() {
    var name = document.getElementById("name").value;
    var nameRegex = /^[a-zA-Z\s]+$/;
    if (!nameRegex.test(name)) {
        alert("Please enter a valid name.");
        return false;
    }
    return true;
}



</script>


<script>
    function validateForm() {
        // Get the date of birth value from the form
        var dateOfBirth = document.getElementById("date_of_birth").value;
        
        // Calculate the minimum age required (18 years old)
        var today = new Date();
        var minAgeDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
        
        // Convert the date of birth and minimum age date to Date objects
        var dateOfBirthObj = new Date(dateOfBirth);
        var minAgeDateObj = new Date(minAgeDate);
        
        // Compare the date of birth with the minimum age date
        if (dateOfBirthObj > minAgeDateObj) {
            alert("You must be at least 18 years old to proceed.");
            return false; // Prevent form submission
        }
        
        return true; // Allow form submission
    }
</script>

    <?php endif; ?>
</body>
</html>

</html>
