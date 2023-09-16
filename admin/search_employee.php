<?php
include 'header.html';
// Database connection details
$host = 'localhost';
$dbname = 'hrms';
$username = 'root';
$password = '';

// Create a new PDO instance
$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Function to search for a user by name, ID, or username
function searchUser($searchTerm, $db) {
    // Prepare the query to search for the user
    $query = "SELECT * FROM users WHERE first_name LIKE :searchTerm OR id = :searchTerm ";
    $stmt = $db->prepare($query);

    // Bind the search term to the query
    $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');

    // Execute the query
    $stmt->execute();

    // Fetch all the results as an associative array
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the search term from the form
    $searchTerm = $_POST['search'];

    // Call the searchUser function
    $users = searchUser($searchTerm, $db);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Search</title>
    <style>
      .container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.user-info {
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
}

.user-info h2 {
    margin-top: 0;
}

.user-info p {
    margin: 5px 0;
}

.no-user {
    text-align: center;
    color: red;
    font-weight: bold;
}

    </style>
</head>
<body>
<div class="container">
    <h1>User Search</h1>
    <form method="post" action="">
        <label for="search">Search by Name: </label>
        <input type="text" id="search" name="search" required>
        <input type="submit" value="Search">
    </form>
    <div id="user-info" class="user-info">
        <?php
        if (isset($users)) {
            if (count($users) > 0) {
                foreach ($users as $user) {
                    echo "<h2>User ID: " . $user['id'] . "</h2>";
                    echo "<p>Username: " . $user['username'] . "</p>";
                    echo "<p>Name: " . $user['first_name'] . " " . $user['last_name'] . "</p>";
                    echo "<p>Email: " . $user['email'] . "</p>";
                    echo "<p>Phone: " . $user['phone'] . "</p>";
                    echo "<p>Department: " . $user['department'] . "</p>";
                    echo "<p>Position: " . $user['position'] . "</p>";
                    echo "<hr>";
                }
            } else {
                echo "<p class='no-user'>No user found.</p>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>
