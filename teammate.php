<?php
include_once("dbconnect.php");
include_once("header.php");
include_once("navigation_header.php");
?>
<?php
if(isset($_COOKIE["username"]))
{
    //()Add Meeting to DB
    if((isset($_POST["submit_meeting"])) &&
    (!empty($_POST["datepicker"])) &&
    (!empty($_POST["additionalInfo"])) &&
    (!empty($_POST["time"])))
    {
        $time = explode(" ",$_POST["datepicker"]);
        $time[0] = substr_replace('Mon', 'Montag',$_POST["datepicker"]);
        $time[0] = substr_replace('Tue', 'Dienstag',$_POST["datepicker"]);
        $time[0] = substr_replace('Wed', 'Mittwoch',$_POST["datepicker"]);
        $time[0] = substr_replace('Thu', 'Donnerstag',$_POST["datepicker"]);
        $time[0] = substr_replace('Fri', 'Freitag',$_POST["datepicker"]);
        $time[0] = substr_replace('Sat', 'Samstag',$_POST["datepicker"]);
        $time[0] = substr_replace('Sun', 'Sonntag',$_POST["datepicker"]);
        $meeting = trim(htmlspecialchars($time[0] . ' ' .$time[1]. ' ' .$_POST["time"]. ' Uhr - ' .$_POST["additionalInfo"]));
        $object = new User;
        $nextId = $object->getNextIncrementIdFromTeammate();
        $object = new User;
        $result = $object->setNewMeeting($meeting, $_COOKIE["username"], $nextId);
        if($result){
        echo '<div class="w3-container w3-tiny w3-text-green">Meeting created sucessfully.</div><br>';
        }
        else{ echo "Something went wrong."; }
    }       
    else{}

    //()Delete a Meeting from DB
    if((isset($_GET["delmeetingid"])) && ($_COOKIE["role"] = "admin")){
        $object = new User;
        $result = $object->deleteMeetingFromTeammate($_GET["delmeetingid"]);
    }

    //()SORT Meetings by Order_ID
    if(isset($_GET["orderidup"]))
    {
        $object = new User;
        $update = $object->getActualOrderIdFromTeammate($_GET["orderidup"]);
        if(isset($_GET["orderidup"]))
        {      
            $newValueOrderId = $update - 1;
        }
        $object = new User;
        $pdo = $object->updateOrderidFromTeammate($newValueOrderId, $_GET["orderidup"]);
        unset($_GET["orderidup"]);
    }
    if(isset($_GET["orderiddown"]))
    {
        $object = new User;
        $update = $object->getActualOrderIdFromTeammate($_GET["orderiddown"]);
        if(isset($_GET["orderiddown"]))
        {      
            $newValueOrderId = $update + 1;
        }
        $object = new User;
        $pdo = $object->updateOrderidFromTeammate($newValueOrderId, $_GET["orderiddown"]);
        unset($_GET["orderidown"]);
    }

    //()Attend to a Meeting
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $user_id = $_COOKIE["username"];        
        $object = new User;
        $result = $object->setAttendToMeetingId($id);
        $string = $result['attend'];
    
        //String vergleichen ob UserID bereits enthalten
        if(strpos($string,$user_id)!==false){
            //nichts unternehmen
        }
        else{
            //Falls UserID nicht enthalten an den String die UserID anhängen und in die DB schreiben
            $result_fin = ''.$string. '' .$_COOKIE["username"].'|';
            // PDO Write Attend
            $object2 = new User;
            $sql_query = $object2->setAttendToMeetingIdInTeammate($result_fin, $id);
        }
    }

    //()Deny to a Meeting
    if(isset($_GET["delid"])){
        $delid = $_GET["delid"];
        $user_id = $_COOKIE["username"] . '|';
        $object = new User;
        $result = $object->getAttendToMeetingId($delid);

        //Array in String umwandeln
        $string = $result["attend"];

        //Wenn "UserID," im String enthalten rauslöschen und in DB UPDATEN
        if($string != $str=str_replace($user_id,"",$string))
        {
            $object = new User;
            $result = $object->delAttendToMeetingId($str,$delid);
        }
        else{}
    }

    //()DB ABFRAGE ALLE MEETINGS
    $object = new User;
    $result = $object->getAllMeetingsInTeammate();

    if(isset($result)){ 
        //UI Anlegen neuer Meetings
        if($_COOKIE["role"] === "admin")
        {?>
        <div class="w3-center w3-card w3-border w3-padding">
            <form class="" action="teammate.php" method="POST">
            <input class="" type="text" id="datepicker" name="datepicker" placeholder="date" style="max-width:90px">
            <input type="time" class="" name="time" style="max-width:90px">   
            <input style="max-width:90px" type="text" name="additionalInfo"placeholder="info">
            <input class="w3-button w3-lime w3-align-right" name="submit_meeting" type="submit" value="Add">
            </form>
        </div>
        <?php }

        //Anzeige Haupttable Teammate
        foreach($result AS $array)
        { ?>
        <table class="w3-container w3-center w3-centered w3-card" style="width:100%">
        
        <!-- UI ADMIN Delete Meeting -->
            <tr>
                <td class="w3-container w3-lime" colspan="3">
                    <?php echo $array['meeting']; ?>
                    <td rowspan="3">
                    <div class="w3-small w3-center"> <?php
                    if(($_COOKIE['user_id'])==45){ ?>
                    <div class="w3-right w3-small"><a href="?delmeetingid=<?php echo $array["meeting_id"] ?> "><i class="fas fa-trash-alt"></i></a></div><br><br><br>
                    <div class="w3-right w3-small"><a href="?orderidup=<?php echo $array["meeting_id"] ?> "><i class="fas fa-arrow-up"></i></a></div><br>
                    <div class="w3-right w3-tiny"><?php echo $array["order_id"]; ?> </a></div>
                    <br>
                    <div class="w3-right w3-small"><a href="?orderiddown=<?php echo $array["meeting_id"] ?> "><i class="fas fa-arrow-down"></i></a></div>
                    </td><?php 
                    }
                    ?>
                    </div>
                </td>
            </tr>
                <td style="background-color:#d3e683" ><div class="w3-container"><b>Player</b></td>
                <td style="background-color:#d3e683"><div class="w3-container"><b>Join</b></td>
                <td style="background-color:#d3e683"><div class="w3-container"><b>Participants</b></td>
            </tr>
            <tr>

    <!-- Ausgabe Spieleranzahl -->
                <td style="background-color:#f2fad2" style="">
                    <?php 
                    $ex_user = explode("|",$array["attend"]);
                    //erstellen des gespeicherten ID Strings in ein Array
                    $sliced = array_slice($ex_user, 0, -1);
                    $count = count($sliced);
                    ?>
                    <div class="w3-container w3-xxxlarge"><?php echo $count; ?></div>
                </td>
    <!-- Zu oder Absagen -->    
                <td class="w3-container" style="background-color:#f2fad2" style=""> 
                    <a href="teammate.php?id=<?php echo $array['meeting_id'] ?>"><i class="far fa-check-circle w3-xxxlarge" style="color:#36a340"></i></a>
                    <a href="teammate.php?delid=<?php echo $array['meeting_id'] ?>"><i class="fas fa-times-circle w3-xxxlarge" style="color:#ff7373"></i></a> <br>
                </td>
    <!-- Ausgabe Participants -->           
                <td class="w3-container" style="background-color:#f2fad2"> 
                    <div class="w3-dropdown-hover w3-small">
                    <img src="./img/participants_icon.png" width="60" height="60" style="background-color:#f2fad2" style.hover="background-color:#f2fad2">
                    <div class="w3-dropdown-content w3-lime w3-border w3-border-black w3-display-topmiddle">
                    <?php
                    foreach($sliced AS $ex_user_id){
                        echo '<div class="w3-bar-item w3-button w3-centered w3-hover-none">' . $ex_user_id . '</div>';
                        } ?>
                    </div>
                    </div>
                    
                </td>
            </tr>
            <tr>
                <td></td>
                    </tr><p></p>
            <?php } ?>
        </table>

    <?php 
    }else{ echo "No data from database."; }   
}
else
{
    header("location:index.php");
} 
include_once("footer.php");
?>