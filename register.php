<?php 
include_once("dbconnect.php");
include_once("header.php");
include_once("navigation_header.php");

		//Abfrage ob das Formular abgeschickt wurde und darunter alle Filter
if (isset($_POST["submit_reg"]))
{
	if(($_POST["password"]) == ($_POST["password2"]) && 
	($emailadress = filter_var($_POST["emailadress"], FILTER_VALIDATE_EMAIL)) && 
	(!empty($_POST["firstname"])) && 
	(!empty($_POST["lastname"])) &&
	(!empty($_POST["password"])) && 
	(!empty($_POST["password2"])) && 
	(!empty($_POST["emailadress"])) && 
	(empty($_POST['website'])) &&
	(strlen($_POST["password"]) >= "6"))
	{
		//Usernamevariable setzen
		$username = trim(htmlspecialchars($_POST["firstname"] . ' ' . $_POST["lastname"]));
		$emailadress = trim(htmlspecialchars($_POST["emailadress"]));

		// PDO ABFRAGE 
		$object = new User;
		$sqlstmt_array = $object->getUserViaEmailadressInLogin($emailadress);
		print_r($sqlstmt_array);

			// ABFRAGE OB USER NEU 
		if (empty($sqlstmt_array))
		{
			// Variablen vorbereiten
			$encrypted_password = password_hash($_POST["password"], PASSWORD_DEFAULT);
			$time = time();
			$time_fin = date('d.m.Y - H:i:s', $time);
			$role = "user";

			//PDO REGISTER NEW USER IN DB
			$regUser = $object->setNewUserToLogin($username,$encrypted_password,$time_fin,$emailadress,$role);
			
		}
		else { echo '<div class="w3-tiny w3-container w3-text-red">Emailadress is already taken!</div>'; }
		

	}
	else if(strlen($_POST["password"]) <= "5") { echo '<div class="w3-tiny w3-text-red">Password too short!</div>'; }
	else if (($_POST["password"]) != ($_POST["password2"])) { echo '<div class="w3-tiny w3-text-red">Passwords not equal.</div>'; }
	else if ($emailadress = filter_var($_POST["emailadress"], FILTER_VALIDATE_EMAIL) == FALSE) { echo '<div class="w3-tiny w3-text-red">Email is not valid.</div>'; }
	else{ echo '<div class="w3-tiny w3-text-red">You have to fill every field!</div>'; }
}
else{}

?>
<form class="" action="" method="POST">
<p><input class="w3-large w3-input w3-hover-border-lime" type="text" name="emailadress" placeholder="Email adress"></p>
<table style="width:100%"><tr><td><input class="w3-large w3-input w3-hover-border-lime" type="text" name="firstname" placeholder="First name"></td>
<td><input class="w3-large w3-input w3-hover-border-lime" type="text" name="lastname" placeholder="Last name"></td></tr>
<tr><td><input class="w3-large  w3-input  w3-hover-border-lime" type="password" name="password" id="myInput" placeholder="password (min 6 char)"></td>
<td><input class="w3-large w3-input w3-hover-border-lime" type="password" name="password2" id="myInput2" placeholder="Repeat password"></td></tr></table>
<div class="w3-padding"><input class="w3-check w3-container w3-large w3-hover-border-lime" type="checkbox" onclick="showPasswords()"> Show passwords</div>

<script>
function showPasswords() {
	
	let x = document.getElementById("myInput");
	let y = document.getElementById("myInput2");
	if ((x.type === "password") && (y.type ==="password")) {
	  x.type = "text";
	  y.type = "text";
	} else {
	  x.type = "password";
	  y.type = "password";
	}
  }
</script>
<p><div class="w3-center"><input class="w3-large w3-center w3-button w3-light-grey w3-round-large" type="submit" name="submit_reg" value="Register"></div><br>

<!--SPAMSCHUTZ-->
<input class="w3-hide" type="text" id="website" name="website"/>
</form>


<?php 
include_once("footer.php");
?>
