<?php
include_once("header.php");
?>
<html>
<header>
<title>Bierliste</title>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</header>
<body>
</body>
<?php
	
		
		setcookie("username", "", time() - 3600);
		setcookie("user_id", "", time() - 3600);
		setcookie("role", "", time() - 3600);
		setcookie("emailadress", "", time() - 3600);
		setcookie("img_path", "", time() - 3600);

	
	
		header("location: index.php");
	
	
	

	?>

</html>

