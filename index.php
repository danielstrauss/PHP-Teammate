<?php 
include_once("header.php");
include_once("dbconnect.php");
include_once("navigation_header.php");

//WENN FORMULAR ABGESENDET WURDE
if(isset($_POST["submit"]))
{
	//POST VARIABLEN ÜBERGEBEN
	$password=$_POST["password"];
	
	//FUNCTION getUserViaEmailadressInLogin in Class User aufgerufen
	$object = new User;
	$username_array = $object->getUserViaEmailadressInLogin($_POST['emailadress']);
	
	//Passwort Check 
	if(password_verify($_POST["password"], $username_array["password"])){
		setcookie('username', $username_array["username"], time()+(360000*10000));
		setcookie('user_id', $username_array["id"], time()+(360000*10000));
		setcookie('role', $username_array["role"], time()+(360000*10000));
		setcookie('emailadress', $username_array["emailadress"], time()+360000*10000);
		setcookie('img_path', $username_array["img_path"], time()+360000*10000);
		
		//ZEIT VARIABLEN SETZEN FÜR UPDATE LAST LOGIN
		$timelogin = time();
		$timelogin_fin = date('d.m.Y - H:i:s',$timelogin);
		$updateLastLogin = $object->setLastLoginTimeInLogin($timelogin_fin,$username_array['id']);

		//INDEX.php neuladen für Header
		header("location:index.php");
		exit;
	}
	else if ($username_array['emailadress'] != $_POST['emailadress']) { echo '<div class="w3-container w3-tiny w3-text-red"> Emailadress not registered yet!</div><div class="w3-tiny w3-container"><a href="register.php"> Register here!</a></div>'; }
	else{ echo '<div class="w3-container w3-tiny w3-text-red">Password is wrong!</div>'; }
}	
else{ 
}

// Loginmaske
if(!isset($_COOKIE["user_id"]))
{ ?>
	<!-- <div class="w3-center"><input style="width:20%" class="w3-container w3-input w3-hover-border-lime" name="username"></div><br> -->
	<form class="w3-panel" action="" method="POST">
	<p><input class="w3-large w3-input w3-hover-border-lime" type="text" name="emailadress" placeholder="Emailadress"></p>
	<p><input class="w3-large w3-input w3-hover-border-lime" type="password" name="password" id="myInput" placeholder="Password"></p>
	<p><div class="w3-padding"><input class="w3-check w3-container w3-large w3-hover-border-lime" type="checkbox" onclick="showPasswords()"> Show password</div></p><br>
	<p><div class="w3-center"><input class="w3-large w3-center w3-button w3-light-grey w3-round-large" type="submit" name="submit" value="Login"></div>
	</form>

	<script>function showPasswords() { let x = document.getElementById("myInput");	
		if (x.type === "password") {
		x.type = "text";
		} else {
		x.type = "password";
		}}</script>
	
<?php
}
else
{ 
	
	?>
<div class="w3-container w3-left-align w3-padding"><h4>Welcome!</h4></div><br>
<?php } ?>
</body>
<?php include_once("footer.php") ?>
