<?php

// Connect to the database
$db = new PDO('mysql:host=localhost;dbname=hrms', 'root', '');

// Get the employee ID and details from the form submission
$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$department = $_POST['department'];
$position = $_POST['position'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$salary = $_POST['salary'];
$user_id = $_POST['user_id'];
$gender = $_POST['gender'];
$date_of_birth = $_POST['date_of_birth'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$country = $_POST['country'];
$emergency_contact_name = $_POST['emergency_contact_name'];
$emergency_contact_phone = $_POST['emergency_contact_phone'];

// Update the employee details in the database
$sql = 'UPDATE employees SET name = :name, email = :email, phone = :phone, department = :department, position = :position, start_date = :start_date, end_date = :end_date, salary = :salary, user_id = :user_id, gender = :gender, date_of_birth = :date_of_birth, address = :address, city = :city, state = :state, zip = :zip, country = :country, emergency_contact_name = :emergency_contact_name, emergency_contact_phone = :emergency_contact_phone WHERE id = :id';
$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':department', $department);
$stmt->bindParam(':position', $position);
$stmt->bindParam(':start_date', $start_date);
$stmt->bindParam(':end_date', $end_date);
$stmt->bindParam(':salary', $salary);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':gender', $gender);
$stmt->bindParam(':date_of_birth', $date_of_birth);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':city', $city);
$stmt->bindParam(':state', $state);
$stmt->bindParam(':zip', $zip);
$stmt->bindParam(':country', $country);
$stmt->bindParam(':emergency_contact_name', $emergency_contact_name);
$stmt->bindParam(':emergency_contact_phone', $emergency_contact_phone);
$stmt->bindParam(':id', $id);
$stmt->execute();

// Redirect to the employee details page
header('Location: list.php?id=' . $id);
exit;

// Close the database connection
$db = null;

?>
