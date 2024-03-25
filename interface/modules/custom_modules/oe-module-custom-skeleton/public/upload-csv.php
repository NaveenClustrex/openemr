<?php
// Include OpenEMR's header
require_once("../../../../globals.php");
require_once('../../../../../library/sql.inc.php');

// Check for user authentication
if (!isset($_SESSION['authUser'])) {
    header("Location: " . $webroot . "/interface/main/main_screen.php?error=Not%20Logged%20In");
    exit;
}


if (isset($_POST['upload'])) {
    if (isset($_POST['csv_data'])) {
        $result = sqlQuery("select max(pid)+1 as pid from patient_data");
        $newpid = 1;
        if ($result['pid'] > 1) {
            $newpid = $result['pid'];
        }
        $csv_data = base64_decode($_POST['csv_data']);
        $file = tmpfile();
        fwrite($file, $csv_data);
        fseek($file, 0);
        $csv_data = fgetcsv($file);
        $index=0;
        while ($csv_data !== false) {
            // $column1 = $mysqli->real_escape_string($csv_data[0]);
            if ($index >0){
                
            // echo nl2br($csv_data[0].$csv_data[1].$csv_data[2]."\n")  ;
            $query = "INSERT INTO `patient_data` (`fname`, `lname`, `mname`, `DOB`, `sex`, `ss`, `pid`, `street`, `city`, `state`, `postal_code`, `phone_home`, `email`) VALUES (
                '" . $csv_data[0] . "',   
                '" . $csv_data[1] . "',   
                '',                      
                '" . $csv_data[2] . "',   
                '" . $csv_data[3] . "',   
                '" . $csv_data[4] . "',  
                '".$newpid."',                      
                '" . $csv_data[7] . "',   
                '" . $csv_data[8] . "',   
                '" . $csv_data[9] . "',  
                '" . $csv_data[10] . "',  
                '" . $csv_data[5] . "',   
                '" . $csv_data[6] . "'    
            );";
            $newid = sqlInsert($query);
            $newpid++;
            }
            // $query="INSERT INTO `patient_data` (`fname`, `lname`, `mname`, `DOB`,`sex`,`ss`,`pid`, `street`,  `city`, `state`,`postal_code`,`phone_home`,`email`) VALUES ( '".$csv_data[7]."', '".$csv_data[8]."', '', '".$csv_data[14]."',".$newpid.");";
            
            
            $csv_data = fgetcsv($file);
            $index++;
        }

        fclose($file);
        echo "CSV data has been successfully uploaded to OpenEMR database.";
    } else {
        echo "Error: CSV data not found.";
    }
}



// query ="INSERT INTO `patient_data`
// (`title`, `language`, `financial`, `fname`, `lname`, `mname`, `DOB`, `street`, `postal_code`, `city`, `state`,  `drivers_license`, `ss`, `occupation`, `phone_home`, `phone_biz`, `phone_contact`, `phone_cell`, `status`, `contact_relationship`, `date`, `sex`, `referrer`, `referrerID`, `providerID`, `email`, `ethnoracial`, `interpretter`, `migrantseasonal`, `family_size`, `monthly_income`, `homeless`, `financial_review`, `pubpid`, `pid`, `genericname1`, `genericval1`, `genericname2`, `genericval2`) VALUES ( 'Mr.', 'english', '', 'Jillian', 'Mahoney', '', '1968-08-11', '444 North State Street', '90204', 'Santa Ana', 'CA', '', '222-11-1111', '', '(808) 555-4444', '(808) 555-3333', '(808) 555-5555', '', 'married', '', '2004-01-19 12:14:06', 'Female', 'Ynez Jones', '', 4, '', '', '', '', '', '', '', '2021-01-01 00:00:00', '35', 35,'','','','');"


?>

