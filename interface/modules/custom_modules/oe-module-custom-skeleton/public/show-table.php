<!DOCTYPE html>
<html>
<head>
    <title>CSV File to Table</title>
</head>
<body>
    <h1>CSV File Contents</h1>
    <div style="height:45vh;overflow:scroll">
    <?php

    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file_name = $_FILES['csv_file']['name'];
        $file_tmp = $_FILES['csv_file']['tmp_name'];

        if (strtolower(pathinfo($file_name, PATHINFO_EXTENSION)) == 'csv') {
            $file = fopen($file_tmp, 'r');
            
            echo '<table border="1">';
            while (($data = fgetcsv($file)) !== false) {
                echo '<tr>';
                foreach ($data as $cell) {
                    echo '<td>' . htmlspecialchars($cell) . '</td>';
                }
                echo '</tr>';
            }
            echo '</table>';
            
            fclose($file);
        } else {
            echo '<p>Error: The uploaded file is not a CSV.</p>';
        }
    } else {
        echo '<p>Error: Please upload a CSV file.</p>';
    }
    ?>
    </div>
    <p><a href="sample-index.php">Upload another CSV file</a></p>
</body>
</html>


<?php
// Include OpenEMR's header
require_once("../../../../globals.php");
require_once('../../../../../library/sql.inc.php');

// Check for user authentication
if (!isset($_SESSION['authUser'])) {
    header("Location: " . $webroot . "/interface/main/main_screen.php?error=Not%20Logged%20In");
    exit;
}


$result = sqlQuery("select max(pid)+1 as pid from patient_data");
$newpid = 1;

if ($result['pid'] > 1) {
    $newpid = $result['pid'];
}
echo $newpid;
// query ="INSERT INTO `patient_data`
// (`title`, `language`, `financial`, `fname`, `lname`, `mname`, `DOB`, `street`, `postal_code`, `city`, `state`,  `drivers_license`, `ss`, `occupation`, `phone_home`, `phone_biz`, `phone_contact`, `phone_cell`, `status`, `contact_relationship`, `date`, `sex`, `referrer`, `referrerID`, `providerID`, `email`, `ethnoracial`, `interpretter`, `migrantseasonal`, `family_size`, `monthly_income`, `homeless`, `financial_review`, `pubpid`, `pid`, `genericname1`, `genericval1`, `genericname2`, `genericval2`) VALUES ( 'Mr.', 'english', '', 'Jillian', 'Mahoney', '', '1968-08-11', '444 North State Street', '90204', 'Santa Ana', 'CA', '', '222-11-1111', '', '(808) 555-4444', '(808) 555-3333', '(808) 555-5555', '', 'married', '', '2004-01-19 12:14:06', 'Female', 'Ynez Jones', '', 4, '', '', '', '', '', '', '', '2021-01-01 00:00:00', '35', 35,'','','','');"

$query="INSERT INTO `patient_data` (`fname`, `lname`, `mname`, `DOB`,`pid`) VALUES ( 'Jillian', 'Mahoney', '', '1968-08-11',".$newpid.");";

$newid = sqlInsert($query);
// echo "<h2>" . $GLOBALS. "</h2>";
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data (you should perform more validation)
    $patientName = mysqli_real_escape_string($GLOBALS['connect'], $_POST['patient_name']);
    $patientDOB = mysqli_real_escape_string($GLOBALS['connect'], $_POST['patient_dob']);

    // Insert data into the patient table (you need to adapt this to OpenEMR's schema)
    $sql = "INSERT INTO patient_data (name, dob) VALUES ('$patientName', '$patientDOB')";
    if (mysqli_query($GLOBALS['connect'], $sql)) {
        echo "Patient data inserted successfully.";
    } else {
        echo "Error: " . mysqli_error($GLOBALS['connect']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Custom Patient Insert</title>
</head>
<body>
    <h1>Custom Patient Insert</h1>
    <form method="POST" action="sample-index.php">
        <!-- <label for="patient_name">Patient Name:</label>
        <input type="text" name="patient_name" required><br>

        <label for="patient_dob">Date of Birth:</label>
        <input type="date" name="patient_dob" required><br> -->

        <input type="submit" value="Insert">
    </form>
</body>
</html>
