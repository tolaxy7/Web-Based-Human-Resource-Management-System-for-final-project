<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrms";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to fetch total number of employees
function getTotalEmployeeCount($conn) {
    $sql = "SELECT COUNT(*) AS total FROM employees";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

// Function to fetch gender distribution
function getGenderDistribution($conn) {
    $sql = "SELECT gender, COUNT(*) AS count FROM employees GROUP BY gender";
    $result = mysqli_query($conn, $sql);
    $distribution = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $distribution[$row['gender']] = $row['count'];
    }
    return $distribution;
}

// Function to fetch age distribution
function getAgeDistribution($conn) {
    $sql = "SELECT FLOOR(DATEDIFF(CURRENT_DATE, date_of_birth) / 365) AS age_group, COUNT(*) AS count FROM employees GROUP BY age_group";
    $result = mysqli_query($conn, $sql);
    $distribution = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $distribution[$row['age_group']] = $row['count'];
    }
    return $distribution;
}

// Function to fetch department-wise employee count
function getDepartmentEmployeeCount($conn) {
    $sql = "SELECT department, COUNT(*) AS count FROM employees GROUP BY department";
    $result = mysqli_query($conn, $sql);
    $distribution = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $distribution[$row['department']] = $row['count'];
    }
    return $distribution;
}

// Function to fetch job title distribution
function getJobTitleDistribution($conn) {
    $sql = "SELECT position, COUNT(*) AS count FROM employees GROUP BY position";
    $result = mysqli_query($conn, $sql);
    $distribution = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $distribution[$row['position']] = $row['count'];
    }
    return $distribution;
}

// Fetch and display employee statistics
$totalEmployees = getTotalEmployeeCount($conn);
$genderDistribution = getGenderDistribution($conn);
$ageDistribution = getAgeDistribution($conn);
$departmentEmployeeCount = getDepartmentEmployeeCount($conn);
$jobTitleDistribution = getJobTitleDistribution($conn);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>HR Department Dashboard</title>
    <style>
        /* CSS styles for employee statistics */

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .section-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .employee-statistics {
            margin-top: 20px;
        }

        .employee-statistics-item {
            margin-bottom: 10px;
        }

        .statistic-label {
            font-weight: bold;
        }

        .statistic-value {
            margin-left: 10px;
        }

        .gender-distribution {
            list-style-type: none;
            padding: 0;
            margin-top: 10px;
        }

        .gender-distribution li {
            display: inline-block;
            margin-right: 10px;
        }

        .gender-male {
            color: #1f77b4;
        }

        .gender-female {
            color: #ff7f0e;
        }

        .gender-other {
            color: #2ca02c;
        }

        .age-distribution {
            list-style-type: none;
            padding: 0;
            margin-top: 10px;
        }

        .age-distribution li {
            display: inline-block;
            margin-right: 10px;
        }

        .department-employee-count {
            list-style-type: none;
            padding: 0;
            margin-top: 10px;
        }

        .department-employee-count li {
            margin-bottom: 5px;
        }

        .job-title-distribution {
            list-style-type: none;
            padding: 0;
            margin-top: 10px;
        }

        .job-title-distribution li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="section-header">Employee Statistics</h2>

        <div class="employee-statistics">
            <div class="employee-statistics-item">
                <span class="statistic-label">Total number of employees:</span>
                <span class="statistic-value"><?php echo $totalEmployees; ?></span>
            </div>

            <div class="employee-statistics-item">
                <span class="statistic-label">Gender distribution:</span>
                <ul class="gender-distribution">
                    <?php foreach ($genderDistribution as $gender => $count) { ?>
                        <li class="gender-<?php echo strtolower($gender); ?>"><?php echo $gender . ": " . $count; ?></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="employee-statistics-item">
                <span class="statistic-label">Age distribution:</span>
                <ul class="age-distribution">
                    <?php foreach ($ageDistribution as $ageGroup => $count) { ?>
                        <li><?php echo $ageGroup . " years: " . $count; ?></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="employee-statistics-item">
                <span class="statistic-label">Department-wise employee count:</span>
                <ul class="department-employee-count">
                    <?php foreach ($departmentEmployeeCount as $department => $count) { ?>
                        <li><?php echo $department . ": " . $count; ?></li>
                    <?php } ?>
                </ul>
            </div>

            <div class="employee-statistics-item">
                <span class="statistic-label">Job title distribution:</span>
                <ul class="job-title-distribution">
                    <?php foreach ($jobTitleDistribution as $jobTitle => $count) { ?>
                        <li><?php echo $jobTitle . ": " . $count; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
