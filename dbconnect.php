<?php
//___________________________________________________
//DBCONNECT PDO
include_once("./pdo/db_connect_pdo.php");
include_once("./pdo/user_functions.php");


//___________________________________________________
//DBCONNECT MYSQLI
$db = mysqli_connect("localhost", "mysql_user", "hOLuVixuQOqi6u3i8a7On4k4qOTi6O", "mysql") or die ("no connection");
    //ERROR BEI DBCONNECT
    if ($db->connect_errno) 
    {
        printf("Connect failed: %s\n", $db->connect_error);
        exit();
    }
    ?>