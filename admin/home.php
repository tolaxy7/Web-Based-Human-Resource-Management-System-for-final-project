<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Home Page</title>
  <link rel="stylesheet" href="css/home.css">
</head>
<body>
  <header>
    <h1>Admin Dashboard</h1>
    <nav>
      <a href="home.php">Home</a>
      <a href="empdetail.php">Employees</a>
      <a href="vacancies.php">Vacancies</a>
      <div class="dropdown">
        <button class="dropbtn">Users</button>
        <div class="dropdown-content">
          <a href="register.php">Create User</a>
          <a href="search_employee.php">Search Users</a>
          <a href="users_list.php">Update or remove User</a>          
        </div>
      </div>
      <a href="scheduleview.php">Schedule</a>
      <a href="feedback_view.php">Feedback</a>
      <a href="report.php">Report</a>
      <a href="profile.php">Profile</a>
      <div class="dropdown">
        <button class="dropbtn">More</button>
        <div class="dropdown-content">
          <a href="#">About Us</a>
          <a href="contactus.php">Contact Us</a>
        </div>
      </div>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <main>
    <h2>Welcome, Admin!</h2>
    <p>Please select an option from the navigation menu to continue.</p>
    <?php include 'test.php'; ?>
  </main>

  <footer>
    <p>&copy; 2023 Admin Dashboard</p>
  </footer>
</body>
</html>
