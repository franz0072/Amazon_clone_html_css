<?php
function str_starts_with($haystack, $needle)
{
    return strpos($haystack, $needle) === 0;
}
function str_ends_with($haystack, $needle)
{
    return strrpos($haystack, $needle) + strlen($needle) ===
        strlen($haystack);
}

include('session.php');
if ($session_id == 'santhome03112015021725') {
    include("./dbcon.php");
    error_reporting(0);

    if (isset($_POST['Submit'])) {


        $target_dir = "./uploads/TcUploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 777, true);
        }


        $tc_id = mysqli_real_escape_string($con, $_POST['tc_id']);
        $admno = mysqli_real_escape_string($con, $_POST['admno']);

        $key1 = "jobincetc@123";
        $urladmission_no = md5(md5($key1 . $admno));
        $secure_admno = $urladmission_no;
        $session = md5($urladmission_no);

        $tc_upload_date = date("d/m/Y h:i:s");


        $photo_url = "";
        if (str_ends_with($_FILES['tc_photo']['name'], 'png') || str_ends_with($_FILES['tc_photo']['name'], 'PNG')) {
            $photo_url = $target_dir . $tc_id . ".png";
            move_uploaded_file($_FILES['tc_photo']['tmp_name'], $target_dir . $tc_id . ".png");
        } else if (str_ends_with($_FILES['tc_photo']['name'], 'jpg') || str_ends_with($_FILES['tc_photo']['name'], 'JPG')) {
            $photo_url = $target_dir . $tc_id . ".jpg";
            move_uploaded_file($_FILES['tc_photo']['tmp_name'], $target_dir . $tc_id . ".jpg");
        } else if (str_ends_with($_FILES['tc_photo']['name'], 'jpeg') || str_ends_with($_FILES['tc_photo']['name'], 'JPEG')) {
            $photo_url = $target_dir . $tc_id . ".jpeg";
            move_uploaded_file($_FILES['tc_photo']['tmp_name'], $target_dir . $tc_id . ".jpeg");
        } else if (str_ends_with($_FILES['tc_photo']['name'], 'pdf') || str_ends_with($_FILES['tc_photo']['name'], 'PDF')) {
            $photo_url = $target_dir . $tc_id . ".pdf";
            move_uploaded_file($_FILES['tc_photo']['tmp_name'], $target_dir . $tc_id . ".pdf");
        }

        $existquery = "SELECT * FROM issued_tc where tc_id='$tc_id'";
        $existresult = mysqli_query($con, $existquery);
        $num_rows = mysqli_num_rows($existresult);

        if (!$existresult) {
            die("Query Failed: " . mysqli_error($con));  // Display MySQL error if the query fails
        }


        //echo $num_rows;
        if ($num_rows == 0) {
            $query = "INSERT INTO `issued_tc` (`tc_id`, `admno`,`tc_upload_date`, `photo_url`, `secure_admno`) 
	VALUES
	('$tc_id', '$admno', '$tc_upload_date', '$photo_url','$secure_admno');";
        } else {
            $query = "UPDATE `issued_tc` SET `admno`='$admno',`tc_upload_date`='$tc_upload_date',`photo_url`='$photo_url', `secure_admno`='$secure_admno' WHERE tc_id='$tc_id'";
        }

        $result = mysqli_query($con, $query);
if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}
        if (!mysqli_query($con, $query)) {
            $queryresult = 0;
            header('Location:  Add IssuedTc.php?queryresult=' . $queryresult);
        } else {
            $queryresult = 1;
            header('Location: Add IssuedTc.php?queryresult=' . $queryresult);
        }
    }
}
