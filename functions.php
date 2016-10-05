<?php

	require("../../../config.php");
     /*
	function sum ($x, $y) {
		
		return $x + $y;
	}
	
	echo sum (87656789,7656788675);
	echo "<br>";
	$answer = sum(10,15);
	echo $answer;
	echo "<br>";
	
	function hello ($firstname,$lastname) {
		
		return "Tere tulemast ".$firstname." " .$lastname."!";
	}
	
	echo hello ("Oskar","N.");
	echo "<br>";
	
    */

	////////////////
	///	Signup
	///////////////
	
	// alustan sessiooni et saaks kasutada $_SESSION muutujaid
	session_start();
	
	$database = "if16_case112";
	
	function signup ($email, $password, $name, $gender, $birthday) {
		
		$error = "";
		
		//ühendus
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		//käsk
		$stmt = $mysqli->prepare("INSERT INTO users (email, password, name, gender, birthday) VALUES (?, ?, ?, ?, ?, ?)");
		
		echo $mysqli->error;
		//asendan küsimärgi väärtusetega
		//iga muutuja kohta 1 täht, mis tüüpi muutuja on
		// s- sring, i- integer, d- double/float
		$stmt->bind_param("sssss", $email, $password, $name, $gender, $birthday);
		
		if ($stmt->execute()) {
			
			
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
		
	}
	
	function login($email, $password) {
		
		//ühendus
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		//käsk
		$stmt = $mysqli->prepare(" SELECT id, email, password FROM users WHERE email = ?");
		
		echo $mysqli->error;
		//asendan küsimärgi
		$stmt->bind_param("s", $email);
		
		//määran tulpadele muutujad
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb);
		$stmt->execute();
		
		if ($stmt->fetch()) {
			//oli rida
			
			//võrdlen paroole
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				echo "Kasutaja ".$id." logis sisse.";
				
				$_SESSION["userId"] = $id;
				$_SESSION["email"] = $emailFromDb;
				
				//suunan kasutaja uuele lehele
				header("Location: data.php");
				
			} else {
				$error = "Vale parool!";
			}
			
		} else {
			//ei olnud
			
			$error = "Sellise emailiga ".$email." kasutajat ei olnud!";
			
			
		}
		
		return $error;
		
	}
	//andmete salvestamine andmebaasi
	function savePeople ($sex, $color) {
		
		$error = "";
		
		//ühendus
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		//käsk
		$stmt = $mysqli->prepare("INSERT INTO clothingOnTheCampus (sex, color) VALUES (?, ?)");
		
		echo $mysqli->error;
		//asendan küsimärgi väärtusetega
		//iga muutuja kohta 1 täht, mis tüüpi muutuja on
		// s- sring, i- integer, d- double/float
		$stmt->bind_param("ss", $sex, $color);
		
		if ($stmt->execute()) {
			
			
			echo "salvestamine õnnestus"."<br>";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
		
	}
	//fetchib andmeid andmebaasist
	function getAllPeople () {
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
	
		$stmt = $mysqli->prepare("SELECT id, sex, color, created FROM clothingOnTheCampus");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $sex, $color, $created);
		$stmt->execute();
		
		$result = array();
		
		
		//seni kuni on 1 rida andmeid saada (10 rida = 10 korda)
		while ($stmt->fetch()) {
			
			//echo $color."<br>";
			array_push($result, $color);
			
		}
		$stmt->close();
		$mysqli->close();
		return $result;
		
		
	}





?>