<?php
	require("functions.php");
	
	// kas on sisse loginud, kui ei ole siis suunata login lehele
	
	
	//ei lase minna data lehele
	if (!isset($_SESSION["userId"])) {
		
		header("Location: login.php");
	}
	
	
	//kas ?logout on aadressireal
	if (isset($_GET["logout"])) {
		
		session_destroy();
		
		header("Location: login.php");
	}
	
	//data faili vormi kontroll et väljad poleks tühjad
	if ( isset($_POST["sex"]) &&
		 isset($_POST["color"]) &&
		 !empty($_POST["sex"]) &&
		 !empty($_POST["color"]) 
	) {
		
		savePeople($_POST["sex"], $_POST["color"]);	
	}
	$people = getAllPeople();
	
	echo "<pre>";
	var_dump($people);
	echo "</pre>";

?>

<h1> Data </h1>
<p>
	Tere tulemast <?=$_SESSION["email"]; ?>!
	
	<a href="?logout=1">Logi välja</a>
	
<h1>Salvesta inimene</h1>
<form method="POST">
			
	<label>Sugu</label><br>
	<input type="radio" name="sex" value="male" > Mees<br>
	<input type="radio" name="sex" value="female" > Naine<br>
	<input type="radio" name="sex" value="Unknown" > Ei oska öelda<br>
	
	<!--<input type="text" name="gender" ><br>-->
	
	<br><br>
	<label>Värv</label><br>
	<input name="color" type="color"> 
	
	<br><br>
	<input type="submit" value="Salvesta">
	
</form>