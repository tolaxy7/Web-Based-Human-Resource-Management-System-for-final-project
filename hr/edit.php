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
    $departmentName = $_POST['department'];
    $positionName = $_POST['position'];
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

    // Retrieve the department ID using its name
    $departmentStmt = $db->prepare("SELECT id FROM departments WHERE name = :name");
    $departmentStmt->execute([':name' => $departmentName]);
    $department = $departmentStmt->fetch(PDO::FETCH_ASSOC);
    $departmentId = $department['id'];

    // Retrieve the position ID using its name
    $positionStmt = $db->prepare("SELECT id FROM positions WHERE name = :name");
    $positionStmt->execute([':name' => $positionName]);
    $position = $positionStmt->fetch(PDO::FETCH_ASSOC);
    $positionId = $position['id'];

    $sql = "UPDATE employees SET name=:name, email=:email, phone=:phone, department=:department, position=:position, start_date=:start_date, end_date=:end_date, salary=:salary, gender=:gender, date_of_birth=:date_of_birth, address=:address, city=:city, state=:state, zip=:zip, country=:country, emergency_contact_name=:emergency_contact_name, emergency_contact_phone=:emergency_contact_phone WHERE id=:id";
    $stmt = $db->prepare($sql);
    $stmt->execute(array(
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':department' => $departmentId,
        ':position' => $positionId,
        ':start_date' => $start_date,
        ':end_date' => $end_date,
        ':salary' => $salary,
        ':gender' => $gender,
        ':date_of_birth' => $date_of_birth,
        ':address' => $address,
        ':city' => $city,
        ':state' => $state,
        ':zip' => $zip,
        ':country' => $country,
        ':emergency_contact_name' => $emergency_contact_name,
        ':emergency_contact_phone' => $emergency_contact_phone,
        ':id' => $id
    ));

    header('Location:edit_employee.php?id=' . $id);
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
  
    <style>
    .form-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .form-row {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    label {
        flex-basis: 150px;
        flex-shrink: 0;
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"],
    select {
        flex-grow: 1;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="radio"] {
        margin-right: 5px;
    }

    .error {
        color: red;
        font-size: 12px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>
    <h1>Edit Employee</h1>

    <form id="employeeForm" method="post" action="">
    <div class="form-grid">
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
             <!-- Select department by name -->
    <select name="department" required>
        <?php foreach ($departments as $department) : ?>
            <option value="<?php echo $department['name']; ?>" <?php if ($department['name'] == $employee['department']) echo 'selected'; ?>>
                <?php echo $department['name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
            <span id="departmentError" class="error"></span>
        </div>

        <div class="form-row">
            <label for="position">Position:</label>
                <!-- Select position by name -->
    <select name="position" required>
        <?php foreach ($positions as $position) : ?>
            <option value="<?php echo $position['name']; ?>" <?php if ($position['name'] == $employee['position']) echo 'selected'; ?>>
                <?php echo $position['name']; ?>
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
    </div>
</form>

    <script>
     // Get the form element
const form = document.getElementById('employeeForm');

// Add an event listener for form submission
form.addEventListener('submit', function (event) {
    // Prevent the form from submitting
    event.preventDefault();

    // Validate each field
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const salary = document.getElementById('salary').value;
    const dob = document.getElementById('date_of_birth').value;
    const city = document.getElementById('city').value;
    const state = document.getElementById('state').value;
    const zip = document.getElementById('zip').value;
    const country = document.getElementById('country').value;
    const emergencyContactName = document.getElementById('emergency_contact_name').value;
    const emergencyContactPhone = document.getElementById('emergency_contact_phone').value;

    // Regular expression patterns for validation
    const namePattern = /^[A-Za-z ]{1,100}$/;
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phonePattern = /^09\d{8}$/;
    const salaryPattern = /^\d{1,5}(\.\d{1,9})?$/;
    const zipPattern = /^\d{4}$/;
    const countryPattern = /^[A-Za-z ]{1,100}$/;

    // Error messages
    const errorMessages = {
        name: 'Name should be alphabets only and up to 100 characters long.',
        email: 'Please enter a valid email address.',
        phone: 'Phone number should start with 09 and be 10 digits long.',
        salary: 'Salary should be a number up to 5 digits long (including decimal up to 9 digits).',
        dob: 'You must be at least 18 years old.',
        city: 'City should be alphabets only and up to 100 characters long.',
        state: 'State should be alphabets only and up to 100 characters long.',
        zip: 'ZIP code should be 4 digits long.',
        country: 'Country should be alphabets only and up to 100 characters long.',
        emergencyContactName: 'Emergency contact name should be alphabets only and up to 100 characters long.',
        emergencyContactPhone: 'Emergency contact phone number should start with 09 and be 10 digits long.'
    };

    // Function to display error message
    function displayError(fieldName, errorMessage) {
        const errorElement = document.getElementById(`${fieldName}Error`);
        errorElement.textContent = errorMessage;
    }

    // Function to clear error message
    function clearError(fieldName) {
        const errorElement = document.getElementById(`${fieldName}Error`);
        errorElement.textContent = '';
    }

    // Validate each field and display error if invalid
    let isValid = true;

    if (!name.match(namePattern)) {
        displayError('name', errorMessages.name);
        isValid = false;
    } else {
        clearError('name');
    }

    if (!email.match(emailPattern)) {
        displayError('email', errorMessages.email);
        isValid = false;
    } else {
        clearError('email');
    }

    if (!phone.match(phonePattern)) {
        displayError('phone', errorMessages.phone);
        isValid = false;
    } else {
        clearError('phone');
    }

    if (!salary.match(salaryPattern)) {
        displayError('salary', errorMessages.salary);
        isValid = false;
    } else {
        clearError('salary');
    }

    const currentDate = new Date();
    const selectedDate = new Date(dob);

    if ((currentDate - selectedDate) < 18 * 365 * 24 * 60 * 60 * 1000) {
        displayError('dob', errorMessages.dob);
        isValid = false;
    } else {
        clearError('dob');
    }

    if (!city.match(namePattern)) {
        displayError('city', errorMessages.city);
        isValid = false;
    } else {
        clearError('city');
    }

    if (!state.match(namePattern)) {
        displayError('state', errorMessages.state);
        isValid = false;
    } else {
        clearError('state');
    }

    if (!zip.match(zipPattern)) {
        displayError('zip', errorMessages.zip);
        isValid = false;
    } else {
        clearError('zip');
    }

    if (!country.match(countryPattern)) {
        displayError('country', errorMessages.country);
        isValid = false;
    } else {
        clearError('country');
    }

    if (!emergencyContactName.match(namePattern)) {
        displayError('emergencyContactName', errorMessages.emergencyContactName);
        isValid = false;
    } else {
        clearError('emergencyContactName');
    }

    if (!emergencyContactPhone.match(phonePattern)) {
        displayError('emergencyContactPhone', errorMessages.emergencyContactPhone);
        isValid = false;
    } else {
        clearError('emergencyContactPhone');
    }

    // If all fields are valid, submit the form
    if (isValid) {
        form.submit();
    }
});

    </script>
</body>
</html>
