<?php
include_once("header.php");
include_once("dbconnect.php");
include_once("navigation_header.php");

if(isset($_COOKIE["username"]))
{  
        if(isset($_POST["submit_einkauf"]))
        {
            if(!empty($_POST["bezeichnung"]))
            {
                $time = time();
                $time_fin = date('d.m.Y - H:i:s',$time);
                $username = $_COOKIE["username"];
                $bezeichnung = trim(htmlspecialchars($_POST["bezeichnung"]));
                $sqlstmt = "INSERT INTO einkauf (bezeichnung,added,addedfrom) VALUES ('$bezeichnung','$time_fin','$username')";
                if(mysqli_query($db, $sqlstmt))
                {}
                else{}
            }
            else{
            echo '<div class="w3-container w3-text-red w3-tiny">The field you want to add is not allowed to be empty.</div>';
            }
        }
        else{}  

        if(isset($_GET["delid"]))
        {
            $delid = $_GET["delid"];
            $sqlstmt = "DELETE FROM EINKAUF WHERE id = '$delid'";
            $sqlquery = mysqli_query($db, $sqlstmt);
        }
        else{}


        
        //Anzeige aller Einträge
        $sqlstmt = "SELECT * FROM einkauf ORDER BY id DESC";
        $sqlquery = mysqli_query($db, $sqlstmt);
        $result = mysqli_fetch_all($sqlquery, MYSQLI_ASSOC);
        ?>
        <div class="w3-container"><h5>Shopping:</h5>

        <!-- TabellenStart -->
        <table class="w3-container w3-card w3-striped" style="width:100%">
<!--ANFANG -->
        <tr>
            <td colspan="3">
                <form action="shoppinglist.php" method="POST">
                <input class="w3-input w3-animate-input" style="width:100%" placeholder="Add Ingridients" type="text" name="bezeichnung"> <br>    
            </td> 

            <td class="w3-center">
                <!-- Das Abschicken ist versteckt (w3-hide) -->
                <input type="submit" class="w3-hide w3-green w3-wide" name="submit_einkauf" value="Add">
                

                
                </form>
            </td> 
            </tr>
<!--ENDE -->
        <th class="w3-container w3-small w3-center">Bezeichnung</th
        ><th class="w3-container w3-small w3-center">Added</th>
        <th class="w3-container w3-small w3-center">Added from</th>
        <?php 
        if(isset($_COOKIE["username"]))
        {
             ?> <th class="w3-container w3-small" style="width:5%">Action</th> 
  <?php } ?>




            <?php foreach($result AS $array){?>
                <tr>
                    <td class="w3-container"> <?php echo $array['bezeichnung']; ?> </td>
                    <td class="w3-container w3-tiny w3-center" style=""> <?php echo $array['added']; ?> </td>
                    <td class="w3-container w3-tiny w3-center" style=""> <?php echo $array['addedfrom']; ?> </td>
                    <?php if(isset($_COOKIE["username"])){ ?>
                    <td class="w3-container w3-center" class="w3-tiny" stlye=""><a href=shoppinglist.php?delid=<?php echo $array['id'] ?> value="delete"><i class="fas fa-trash-alt"></i> </td> <?php } ?>
                </tr>
            <?php } ?>
           
        </table>
        </div>

        <?php

}
else{
    header("location:index.php");
}
?>















