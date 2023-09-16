<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Vacancies</title>
  <link rel="stylesheet" href="css/vacancy.css">
</head>
<body>
<?php
  // Connect to the database
  include 'header.html';
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "hrms";
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  // Check if a form has been submitted for adding, deleting, or updating vacancies
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      // Check if the "add vacancy" form has been submitted
      if (isset($_POST["add_vacancy"])) {
          
          // Validate input fields
          $title = $_POST["title"];
          $description =$_POST["description"];
          $department =$_POST["department"];
          $position =$_POST["position"];
          $salary =$_POST["salary"];
          $start_date =$_POST["start_date"];
          $end_date =$_POST["end_date"];

          // Insert new vacancy into the database
          $sql = "INSERT INTO vacancies (title, description, department, position, salary, start_date, end_date) VALUES ('$title', '$description', '$department', '$position', '$salary', '$start_date', '$end_date')";
          if (mysqli_query($conn, $sql)) {
              echo "<div class='success'>New vacancy added successfully</div>";
          } else {
              echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
          }

      }
      
      // Check if the "delete vacancy" form has been submitted
      if (isset($_POST["delete_vacancy"])) {
          
          // Get the ID of the vacancy to delete
          $id =$_POST["id"];

          // Delete the vacancy from the database
          $sql = "DELETE FROM vacancies WHERE id='$id'";
          if (mysqli_query($conn, $sql)) {
              echo "<div class='success'>Vacancy deleted successfully</div>";
          } else {
              echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
          }

      }
      
      // Check if the "update vacancy" form has been submitted
      if (isset($_POST["update_vacancy"])) {
          
          // Get the ID of the vacancy to update
          $id =$_POST["id"];

          // Validate input fields
          $title =$_POST["title"];
          $description =$_POST["description"];
          $department =$_POST["department"];
          $position =$_POST["position"];
          $salary =$_POST["salary"];
          $start_date =$_POST["start_date"];
          $end_date =$_POST["end_date"];

          // Update the vacancy in the database
          $sql = "UPDATE vacancies SET title='$title', description='$description', department='$department', position='$position', salary='$salary', start_date='$start_date', end_date='$end_date' WHERE id='$id'";
          if (mysqli_query($conn, $sql)) {
              echo "<div class='success'>Vacancy updated successfully</div>";
          } else {
              echo "<div class='error'>Error: " . mysqli_error($conn) . "</div>";
            }
            
           
              }
            }
            ?>
            

    <!-- Add vacancy form -->
    <h3>Add New Vacancy</h3>
    <form id="vacancyForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>
        <label for="department">Department:</label>
        <input type="text" id="department" name="department" required><br><br>
        <label for="position">Position:</label>
        <input type="text" id="position" name="position" required><br><br>
        <label for="salary">Salary:</label>
        <input type="number" step="0.01" id="salary" name="salary" required><br><br>
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required><br><br>
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required><br><br>
        <input type="submit" name="add_vacancy" value="Add Vacancy">
    </form>

    <!-- List of vacancies -->
    <h3>List of Vacancies</h3>

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
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Retrieve all vacancies from the database
                  $sql = "SELECT * FROM vacancies";
                  $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
                  // Output data of each row
                  while($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td>" . $row["title"] . "</td>";
                      echo "<td>" . $row["description"] . "</td>";
                      echo "<td>" . $row["department"] . "</td>";
                      echo "<td>" . $row["position"] . "</td>";
                      echo "<td>" . $row["salary"] . "</td>";
                      echo "<td>" . $row["start_date"] . "</td>";
                      echo "<td>" . $row["end_date"] . "</td>";
                      echo "<td><a href='update_vacancy.php?id=" . $row["id"] . "'>Update</a> | <a href='delete_vacancy.php?id=" . $row["id"] . "'>Delete</a></td>";
                      echo "</tr>";
                  }
              } else {
                  echo "<tr><td colspan='8'>No vacancies found</td></tr>";
              }
              ?>
            </tbody>
    </table>

    <?php
   
         // Close the database connection
         mysqli_close($conn);
         
    ?>

    <script type="text/javascript">
        document.getElementById("vacancyForm").addEventListener("submit", function(event) {
         
        // Get form values
        var title = document.getElementById("title").value;
        var description = document.getElementById("description").value;
        var department = document.getElementById("department").value;
        var position = document.getElementById("position").value;
        var salary = document.getElementById("salary").value;

        // Define regular expressions for validation
        var characterPattern = /^[A-Za-z\s]+$/;
        var salaryPattern = /^\d{4,10}(\.\d{1,2})?$/;

        // Title validation
        if (!characterPattern.test(title) || title.length < 20 || title.length > 100) {
            alert("Title should only contain characters and have a length between 20 and 100 characters.");
            event.preventDefault();
            return false;
        }

        // Description validation
        if (!characterPattern.test(description) || description.length < 20 || description.length > 500) {
            alert("Description should only contain characters and have a length between 20 and 500 characters.");
            event.preventDefault();
            return false;
        }

        // Department validation
        if (!characterPattern.test(department) || department.length < 2 || department.length > 100) {
            alert("Department should only contain characters and have a length between 2 and 100 characters.");
            event.preventDefault();
            return false;
        }

        // Position validation
        if (!characterPattern.test(position) || position.length < 4 || position.length > 100) {
            alert("Position should only contain characters and have a length between 4 and 100 characters.");
            event.preventDefault();
            return false;
        }

        // Salary validation
        if (!salaryPattern.test(salary)) {
            alert("Salary should be a number and have a length between 4 and 10 characters. Optionally, it can have up to 2 decimal places.");
            event.preventDefault();
            return false;
        }

        return true;

        });
    </script>
</body>
</html>
