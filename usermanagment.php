<?php

include_once("dbconnect.php");
include_once("header.php");
include_once("navigation_header.php");

if(isset($_SESSION['username'])&&isset($_SESSION['id']))
{

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
	echo '<div class="w3-margin-left"><h5> Userverwaltung: </h5></div>';
	//Auflistung der User mit foreach
	?>
	<div class="w3-container">
	<table class="w3-table w3-striped w3-tiny w3-card w3-left-align w3-hoverable">	
	<?php
	foreach($ausgabe_array AS $array)
	{
		?>
			<tr>	
				<td>
					<?php echo 'ID: ' . $array['id']; ?>
			</td>
				<td>
					<div class="w3-left-align"><?php echo 'Username: ' . $array['username']; ?></div>
			</td>	
				<td>
					<?php echo 'Passwort: ' . $array['password']; ?>
			</td>	
				<td>
					<a href="admin.php?delid=<?php echo $array['id']; ?>" value="delete"><i class="fas fa-trash-alt"></i></input>	
			</td>
			</tr>
	<?php } ?>
		</table>	
		</div>
	<?php 
	//Einkauf eintragen
	?>
	
	<?php
}
else 
{
	header("location: index.php");
	exit;
}