<?php

include_once("header.php");
if(isset($_COOKIE["username"]) && ($_COOKIE["role"]=="admin"))
{
    include_once("dbconnect.php");
    include_once("navigation_header.php");
    

	?>
	
	<?php
	// Wenn etwas gelöscht werden soll.
	if(isset($_GET["delid"]))
	{
		if(!empty($_GET["delid"]))
		{
			$id = $_GET['delid'];
			$delete_entry = "DELETE FROM login WHERE id = $id";
			$delete_do = mysqli_query($db, $delete_entry);
		}
		
	}
	//SQL Abfrage zur Auflistung der User
	$ausgabe_user = "SELECT * from login";
	$ausgabe_user_query = mysqli_query($db, $ausgabe_user);
	$ausgabe_array = mysqli_fetch_all($ausgabe_user_query, MYSQLI_ASSOC);
	mysqli_free_result($ausgabe_user_query);
	mysqli_close($db);
	echo '<div class="w3-margin-left"><h5> Usermanagment: </h5></div>';
	//Auflistung der User mit foreach
	?>
	<div class="w3-container">
	<table class="w3-container w3-table w3-striped w3-tiny w3-left-align w3-hoverable ">	
	<th>ID</th><th>Username</th><th>Emailadress</th><th>Role</th><th><div class ="w3-right-align">Action</div></th>
	<?php
	foreach($ausgabe_array AS $array)
	{
		?>
			<tr>	
				<td> <?php echo $array['id']; ?> </td>
				<td> <div class="w3-left-align"><?php echo $array['username']; ?></div> </td>	
				<td> <?php echo $array['emailadress']; ?> </td>
				<td> <?php echo $array['role']; ?> </td>
				<td> <div class ="w3-right-align"><a  href="admin_usermanagment.php?delid=<?php echo $array['id']; ?>" value="delete"><i class="fas fa-trash-alt"></i> </div></td>
			</tr>
    <?php } ?>
        </table>
    </div>
	<?php 
}
else 
{
	header("location: index.php");
	exit;
}