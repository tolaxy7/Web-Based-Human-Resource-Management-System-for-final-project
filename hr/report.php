<!DOCTYPE html>
<html>
<head>
  <title>Report Form</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Include CodeMirror JavaScript and CSS files -->
  <link rel="stylesheet" href="css/report.css">
  <link rel="stylesheet" href="codemirror/lib/codemirror.css">
  <link rel="stylesheet" href="codemirror/theme/material.css">
  <script src="codemirror/lib/codemirror.js"></script>
  <script src="codemirror/mode/javascript/javascript.js"></script>
  
  <style>
body {
  font-family: sans-serif;
  font-size: 16px;
  line-height: 1.5;
  margin: 0;
  padding: 0;
}

h1 {
  font-size: 24px;
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-bottom: 20px;
}

input[type="submit"],
.download-button {
  background-color: #4CAF50;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

input[type="submit"]:hover,
.download-button:hover {
  background-color: #3e8e41;
}

.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.container form {
  flex: 1;
  max-width: 400px;
}

.CodeMirror {
  border: 1px solid #ccc;
  height: 200px;
}

pre {
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  padding: 10px;
  margin-bottom: 20px;
}

  </style>
</head>
<body>
<?php require 'header.html';?>

  <h1>Create Report</h1>
  <p><a href="JSON.docx" download>Download json.docx</a></p>
  <div class="container">
  
  <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required><br>

    <label for="description">Description:</label>
    <textarea name="description" id="description"></textarea><br>

    <label for="data">Data (JSON format):</label>
    
    <!-- Create a textarea element for the JSON data -->
    <textarea name="data" id="data"></textarea>

    <p>
      <input type="submit" value="Create Report">
    </p>
  </form>
  </div>

  <!-- Initialize the CodeMirror editor for the JSON data textarea -->
  <script>
    var editor = CodeMirror.fromTextArea(document.getElementById("data"), {
      mode: "application/json",
      theme: "material",
      lineNumbers: true,
      autoCloseBrackets: true,
      matchBrackets: true,
      foldGutter: true,
      gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
    });
  </script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var titleInput = document.getElementById('title');
    var descriptionInput = document.getElementById('description');
    var form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
      if (!validateTitle(titleInput.value)) {
        event.preventDefault();
        alert('Title must be up to 100 characters');
      }

      if (!validateDescription(descriptionInput.value)) {
        event.preventDefault();
        alert('Description must be up to 500 characters');
      }
    });

    function validateTitle(title) {
      return title.length <= 100;
    }

    function validateDescription(description) {
      return description.length <= 500;
    }
  });
</script>


<?php
// Process the form data when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $data = $_POST['data'];

    if (empty($title) || empty($data)) {
        echo "Title and data are required fields.";
    } else {
        // Validate the JSON data
        $json = json_decode($data);
        if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
            echo "Invalid JSON data.";
        } else {
            // Connect to the MySQL database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "hrms";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Error connecting to the database: " . $conn->connect_error);
            }

            // Prepare the MySQL statement and bind the parameters
            $stmt = $conn->prepare("INSERT INTO reports (title, description, data) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $description, $data);

            // Execute the MySQL statement and check for errors
            if (!$stmt->execute()) {
                echo "Error inserting data into the database: " . $conn->error;
            } else {
                echo "Report created successfully!";
            }

            // Close the MySQL connection
            $conn->close();
        }
    }
}
?>
</body>
</html>
