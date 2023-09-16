<?php
include 'header.html';

// Connect to the database
$host = 'localhost';
$db   = 'hrms';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Fetch all users from the users table
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get selected username
    $selectedUsername = $_POST['username'];

    // Fetch user details from the users table
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$selectedUsername]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Error: Employee does not exist in users table";
    } else {
        // Set form field values from user details
        $name = $user['first_name'] . ' ' . $user['last_name'];
        $email = $user['email'];
        $phone = $user['phone'];

        // Fetch department and position from respective tables
        $department_id = $user['department'];
        $position_id = $user['position'];

        $stmt = $pdo->prepare("SELECT name FROM departments WHERE id = ?");
        $stmt->execute([$department_id]);
        $department = $stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT name FROM positions WHERE id = ?");
        $stmt->execute([$position_id]);
        $position = $stmt->fetchColumn();
        
        // Get remaining form data
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

        // Insert employee data into employees table
        $stmt = $pdo->prepare("INSERT INTO employees (name, email, phone, department, position, start_date, end_date, salary, user_id, gender, date_of_birth, address, city, state, zip, country, emergency_contact_name, emergency_contact_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $phone, $department, $position, $start_date, $end_date, $salary, $user['id'], $gender, $date_of_birth, $address, $city, $state, $zip, $country, $emergency_contact_name, $emergency_contact_phone]);

        echo "Employee added successfully";
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>My Form</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        font-size: 16px;
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
      select,
      input[type="date"],
      input[type="number"] {
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
    </style>
  </head>
  <body>
    <form method="post" action="add_employee.php">
      <label for="username">Username:</label>
      <select id="username" name="username" required>
        <option value="">-- Select Username --</option>
        <?php foreach ($users as $user) : ?>
          <option value="<?php echo $user['username']; ?>"><?php echo $user['username']; ?></option>
        <?php endforeach; ?>
      </select>

      <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="" readonly>

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="" readonly>

      <label for="phone">Phone:</label>
      <input type="tel" id="phone" name="phone" value="" readonly>

      <label for="department">Department:</label>
      <input type="text" id="department" name="department" value="" readonly>

      <label for="position">Position:</label>
      <input type="text" id="position" name="position" value="" readonly>

      <label for="start_date">Start Date:</label>
      <input type="date" id="start_date" name="start_date" required>

      <label for="end_date">End Date:</label>
      <input type="date" id="end_date" name="end_date" required>

      <label for="salary">Salary:</label>
      <input type="number" id="salary" name="salary" required>

      <label for="gender">Gender:</label>
      <select id="gender" name="gender" required>
        <option value="">-- Select Gender --</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>

      <label for="date_of_birth">Date of Birth:</label>
      <input type="date" id="date_of_birth" name="date_of_birth" required>

      <label for="address">Address:</label>
      <input type="text" id="address" name="address" required>

      <label for="city">City:</label>
      <input type="text" id="city" name="city" required>

      <label for="state">State:</label>
      <input type="text" id="state" name="state" required>

      <label for="zip">ZIP:</label>
      <input type="text" id="zip" name="zip" required>

      <label for="country">Country:</label>
      <input type="text" id="country" name="country" required>

      <label for="emergency_contact_name">Emergency Contact Name:</label>
      <input type="text" id="emergency_contact_name" name="emergency_contact_name" required>

      <label for="emergency_contact_phone">Emergency Contact Phone:</label>
      <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" required>

      <input type="submit" value="Submit">
    </form>

    <script>
      document.getElementById('employeeForm').addEventListener('submit', function(event) {
    var isValid = true;

    // Date of Birth validation
    var dobInput = document.getElementById('date_of_birth');
    var currentDate = new Date();
    var selectedDate = new Date(dobInput.value);
    var minAge = 18;
    var ageDiff = currentDate.getFullYear() - selectedDate.getFullYear();
    if (ageDiff < minAge || (ageDiff === minAge && currentDate.getMonth() < selectedDate.getMonth()) || (ageDiff === minAge && currentDate.getMonth() === selectedDate.getMonth() && currentDate.getDate() < selectedDate.getDate())) {
        isValid = false;
        document.getElementById('dobError').textContent = 'You must be at least 18 years old.';
    } else {
        document.getElementById('dobError').textContent = '';
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
        document.getElementById('zipError').textContent = 'Invalid Zip code (up to 4 digits, numbers only).';
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

    // Emergency Contact Name validation
    var emergencyNameInput = document.getElementById('emergency_contact_name');
    var emergencyNameRegex = /^[A-Za-z]{1,40}$/;
    if (!emergencyNameRegex.test(emergencyNameInput.value)) {
        isValid = false;
        document.getElementById('emergencyContactNameError').textContent = 'Invalid Emergency Contact Name (up to 40 characters, letters only).';
    } else {
        document.getElementById('emergencyContactNameError').textContent = '';
    }

    // Emergency Contact Phone validation
    var emergencyPhoneInput = document.getElementById('emergency_contact_phone');
    var emergencyPhoneRegex = /^09\d{8}$/;
    if (!emergencyPhoneRegex.test(emergencyPhoneInput.value)) {
        isValid = false;
        document.getElementById('emergencyContactPhoneError').textContent = 'Invalid Emergency Contact Phone number (Ethiopian format: starts with 09, 10 digits).';
    } else {
        document.getElementById('emergencyContactPhoneError').textContent = '';
    }

    if (!isValid) {
        event.preventDefault(); // Prevent form submission if validation fails
    }
});

    </script>
  </body>
</html>
