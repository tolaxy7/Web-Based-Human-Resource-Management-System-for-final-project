<?php
require 'header.html';

$host = 'localhost';
$dbname = 'hrms';
$username = 'root';
$password = '';

$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $salary = $_POST['salary'];
    $gender = $_POST['gender'];
    $date_of_birth = $_POST['date_of_birth'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $emergency_contact_name = $_POST['emergency_contact_name'];
    $emergency_contact_phone = $_POST['emergency_contact_phone'];

    $sql = "UPDATE employees SET name=:name, email=:email, phone=:phone, department=:department, position=:position, start_date=:start_date, end_date=:end_date, salary=:salary, gender=:gender, date_of_birth=:date_of_birth, address=:address, city=:city, state=:state, zip=:zip, country=:country, emergency_contact_name=:emergency_contact_name, emergency_contact_phone=:emergency_contact_phone WHERE id=:id";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(':name' => $name, ':email' => $email, ':phone' => $phone, ':department' => $department, ':position' => $position, ':start_date' => $start_date, ':end_date' => $end_date, ':salary' => $salary, ':gender' => $gender, ':date_of_birth' => $date_of_birth, ':address' => $address, ':city' => $city, ':state' => $state, ':zip' => $zip, ':country' => $country, ':emergency_contact_name' => $emergency_contact_name, ':emergency_contact_phone' => $emergency_contact_phone, ':id' => $id));

    header('Location: empdetail.php?id=' . $id);
    exit();
}

$sql = "SELECT * FROM employees WHERE id=:id";
$stmt = $db->prepare($sql);
$stmt->execute(array(':id' => $id));
$employee = $stmt->fetch(PDO::FETCH_ASSOC);

$departments = $db->query("SELECT * FROM departments")->fetchAll(PDO::FETCH_ASSOC);
$positions = $db->query("SELECT * FROM positions")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Employee</title>
    <link rel="stylesheet" href="css/empedit.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        h1 {
            text-align: center;
        }

        .form-row {
            display: flex;
            margin-bottom: 10px;
        }

        .form-row label {
            flex-basis: 50%;
            margin-bottom: 1px;
            font-weight: bold;
        }

        .form-row input,
        .form-row select {
            flex-basis: 50%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .error {
            color: red;
            font-size: 12px;
        }

        .form-row input[type="submit"] {
            margin-top: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Edit Employee</h1>

    <form id="employeeForm" method="post" action="">
                <div class="form-row">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $employee['name']; ?>" required>
            <span id="nameError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $employee['email']; ?>" required>
            <span id="emailError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo $employee['phone']; ?>" required>
            <span id="phoneError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="department">Department:</label>
            <select id="department" name="department" required>
                <option value="">-- Select Department --</option>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?php echo $dept['id']; ?>" <?php echo ($employee['department'] == $dept['id']) ? 'selected' : ''; ?>>
                        <?php echo $dept['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span id="departmentError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="position">Position:</label>
            <select id="position" name="position" required>
                <option value="">-- Select Position --</option>
                <?php foreach ($positions as $pos): ?>
                    <option value="<?php echo $pos['id']; ?>" <?php echo ($employee['position'] == $pos['id']) ? 'selected' : ''; ?>>
                        <?php echo $pos['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span id="positionError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $employee['start_date']; ?>" required>
            <span id="startDateError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $employee['end_date']; ?>">
            <span id="endDateError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="salary">Salary:</label>
            <input type="number" id="salary" name="salary" value="<?php echo $employee['salary']; ?>" required>
            <span id="salaryError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="gender">Gender:</label>
            <input type="radio" id="male" name="gender" value="Male" <?php echo ($employee['gender'] == 'Male') ? 'checked' : ''; ?>>
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="Female" <?php echo ($employee['gender'] == 'Female') ? 'checked' : ''; ?>>
            <label for="female">Female</label>
            <span id="genderError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $employee['date_of_birth']; ?>" required>
            <span id="dobError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $employee['address']; ?>" required>
            <span id="addressError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo $employee['city']; ?>" required>
            <span id="cityError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?php echo $employee['state']; ?>" required>
            <span id="stateError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="zip">Zip:</label>
            <input type="text" id="zip" name="zip" value="<?php echo $employee['zip']; ?>" required>
            <span id="zipError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo $employee['country']; ?>" required>
            <span id="countryError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="emergency_contact_name">Emergency Contact Name:</label>
            <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo $employee['emergency_contact_name']; ?>" required>
            <span id="emergencyContactNameError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="emergency_contact_phone">Emergency Contact Phone:</label>
            <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="<?php echo $employee['emergency_contact_phone']; ?>" required>
            <span id="emergencyContactPhoneError" class="error"></span>
        </div>

        <div class="form-row">
            <input type="submit" value="Save">
        </div>
    </form>
    <script>
        document.getElementById('employeeForm').addEventListener('submit', function(event) {
            var isValid = true;

            // Name validation
            var nameInput = document.getElementById('name');
            var nameRegex = /^[A-Za-z\s]{1,40}$/;
            if (!nameRegex.test(nameInput.value)) {
                isValid = false;
                document.getElementById('nameError').textContent = 'Name must contain only letters and be up to 40 characters long.';
            } else {
                document.getElementById('nameError').textContent = '';
            }

            // Email validation
            var emailInput = document.getElementById('email');
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput.value)) {
                isValid = false;
                document.getElementById('emailError').textContent = 'Invalid Email.';
            } else {
                document.getElementById('emailError').textContent = '';
            }

            // Phone validation
            var phoneInput = document.getElementById('phone');
            var phoneRegex = /^09\d{8}$/;
            if (!phoneRegex.test(phoneInput.value)) {
                isValid = false;
                document.getElementById('phoneError').textContent = 'Invalid Phone number (Ethiopian format: starts with 09, 10 digits).';
            } else {
                document.getElementById('phoneError').textContent = '';
            }

            // Salary validation
            var salaryInput = document.getElementById('salary');
            var salaryRegex = /^\d{1,6}(?:\.\d{1,12})?$/;
            if (!salaryRegex.test(salaryInput.value)) {
                isValid = false;
                document.getElementById('salaryError').textContent = 'Invalid Salary (up to 6 digits, up to 12 decimal digits if it is a decimal number).';
            } else {
                document.getElementById('salaryError').textContent = '';
            }

            // City validation
            var cityInput = document.getElementById('city');
            var cityRegex = /^[A-Za-z]{1,40}$/;
            if (!cityRegex.test(cityInput.value)) {
                isValid = false;
                document.getElementById('cityError').textContent = 'Invalid City name (up to 40 characters, letters only).';
            } else {
                document.getElementById('cityError').textContent = '';
            }

            // State validation
            var stateInput = document.getElementById('state');
            var stateRegex = /^[A-Za-z]{1,40}$/;
            if (!stateRegex.test(stateInput.value)) {
                isValid = false;
                document.getElementById('stateError').textContent = 'Invalid State name (up to 40 characters, letters only).';
            } else {
                document.getElementById('stateError').textContent = '';
            }
            // Zip validation
            var zipInput = document.getElementById('zip');
            var zipRegex = /^\d{1,4}$/;
            if (!zipRegex.test(zipInput.value)) {
                isValid = false;
                document.getElementById('zipError').textContent = 'Invalid Zip code (up to 4 digits).';
            } else {
                document.getElementById('zipError').textContent = '';
            }

            // Country validation
            var countryInput = document.getElementById('country');
            var countryRegex = /^[A-Za-z]{1,40}$/;
            if (!countryRegex.test(countryInput.value)) {
                isValid = false;
                document.getElementById('countryError').textContent = 'Invalid Country name (up to 40 characters, letters only).';
            } else {
                document.getElementById('countryError').textContent = '';
            }

            if (!isValid) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });
    </script>
</body>
</html>
