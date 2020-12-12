<?php
include_once("dbconnect.php");
if(isset($_POST['submit']) && (isset($_COOKIE['user_id'])))
{
    


        //__________________________________________________FUNKTIONIERT _____________________________________________________
    
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png');
    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            if($fileSize <= 2000000){
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;


                move_uploaded_file($fileTmpName, $fileDestination);



                $mysql_stmt = "UPDATE login SET img_path='$fileDestination' WHERE id = '{$_COOKIE['user_id']}'";
                $mysql_query = mysqli_query($db,$mysql_stmt);
                setcookie('img_path', $fileDestination, time()+(360000*10000));
                header("location:user_cp.php?uploadsuccess");

            }
            else{ header("location:user_cp.php?filetoobig"); }
        }
        else{ header("location:user_cp.php?error"); }
    }
    else{ header("location:user_cp.php?filetype"); }


}
else{ 
    header("location:user_cp.php");
}


?>