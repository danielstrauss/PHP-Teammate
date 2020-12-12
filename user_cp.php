<?php

include_once("dbconnect.php");
include_once("header.php");
include_once("navigation_header.php");

if(isset($_COOKIE['user_id']))
{

    if(isset($_GET['delavatar']))
    {
        echo "test";
        $object = new User;
        $user = $object->getUserViaIdInLogin($_COOKIE['user_id']);
        $del = $object->deleteImgpathFromUser($user['img_path']);
        
            setcookie("img_path", "", time() - 3600);
            header("location:user_cp.php");
    }
        //Upload Anzeigetext Info
        if(isset($_GET['uploadsuccess']))
        {
            echo '<div class="w3-container w3-text-green w3-tiny">Upload complete.</div>';
        }
        else if (isset($_GET['filetoobig']))
        {
            echo '<div class="w3-container w3-text-red w3-tiny">File size is too big. Limit: < 2MB</div>';
        }
        else if (isset($_GET['error']))
        {
            echo '<div class="w3-container w3-text-red w3-tiny">There was an error uploading your file.</div>';
        }
        else if (isset($_GET['filetype']))
        {
            echo '<div class="w3-container w3-text-red w3-tiny">It\'s only allowed to upload png, jpg and jpeg files.</div>';
        }
        
 ?>
    <br>
        <div class="w3-card w3-center" style="width:100%">
        <br>
        
        <img src="<?php if(isset($_COOKIE['img_path'])){ echo $_COOKIE['img_path']; }else{ echo "./img/blank_avatar.png";} ?>" alt="Person" class="w3-border" style="width:85%"><br>
        <a class ="" href="?delavatar"> <?php if(isset($_COOKIE['img_path'])){ echo "Delete picture"; }?></a><p>
        
        <br>
        </div>
    

        <div class="w3-container w3-center w3-lime">
            <br>Upload a profile pic:
        <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file"><button class="w3-large w3-center w3-button w3-light-grey w3-round-large" type="submit" id="fileinput" name="submit">UPLOAD</button>
        </form>
        <br>
    </div>
    
        <?php include_once("footer.php");
    }
    else{
    header("location:index.php");

}

?>