<?php
include_once("header.php");
if(isset($_COOKIE['username']))
{
	include_once("dbconnect.php");
	include_once("navigation_header.php");
	
	?>
	<br>
	<div class="w3-container">Sie befinden sich im Adminbereich"</div>
	<br><br><br><br><br><br><br><br><br><br><br><br>
	<?php header("location: admin_usermanagment.php");
	exit;
	?>

	<?php include_once("footer.php"); ?>
	</body>
	</html>
<?php 
}
?>
