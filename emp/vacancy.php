<!DOCTYPE html>
<html>
<head>
    <title>Vacancies</title>
    <link rel="stylesheet" type="text/css" href="style/vacancy.css">
</head>
<body>
    <header>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="schedule_view.php">Schedule</a></li>
            <li><a href="edit_detail.php">Edit My Info</a></li>
            <li><a href="vacancy.php">Vacancy</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    </header>
    <main>
        <section>
            <h2>Current Vacancies</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Salary</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Connect to database
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "hrms";
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Retrieve vacancies from database
                        $sql = "SELECT * FROM vacancies";
                        $result = $conn->query($sql);

                        // Display vacancies
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["title"] . "</td>";
                                echo "<td>" . $row["description"] . "</td>";
                                echo "<td>" . $row["department"] . "</td>";
                                echo "<td>" . $row["position"] . "</td>";
                                echo "<td>$" . number_format($row["salary"], 2) . "</td>";
                                echo "<td>" . date("M j, Y", strtotime($row["start_date"])) . "</td>";
                                echo "<td>" . date("M j, Y", strtotime($row["end_date"])) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No vacancies found.</td></tr>";
                        }

                        // Close database connection
                        $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>