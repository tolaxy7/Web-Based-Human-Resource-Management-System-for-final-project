<?php

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Get form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  // Validate form data
  if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    // One or more fields are empty
    echo "Please fill out all fields.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Invalid email address
    echo "Invalid email address.";
  } else {
    // Form data is valid, send email
    $to = "tolawaq3@gmail.com.com";
    $headers = "From: $name <$email>" . "\r\n" .
               "Reply-To: $email" . "\r\n" .
               "X-Mailer: PHP/" . phpversion();
    $message = wordwrap($message, 70);
    mail($to, $subject, $message, $headers);
    echo "Your message has been sent.";
  }

} else {
  // Form was not submitted, redirect to contact page
  header("Location: contact.php");
  exit();
}
