<?php
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
	
	function signup ($email, $password) {
		
		$error = "";
		
		//�hendus
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		//k�sk
		$stmt = $mysqli->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
		
		echo $mysqli->error;
		//asendan k�sim�rgi v��rtusetega
		//iga muutuja kohta 1 t�ht, mis t��pi muutuja on
		// s- sring, i- integer, d- double/float
		$stmt->bind_param("ss", $email, $password);
		
		if ($stmt->execute()) {
			
			
			echo "salvestamine �nnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
		
		
	}
	
	function login($email, $password) {
		
		//�hendus
		$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
		//k�sk
		$stmt = $mysqli->prepare(" SELECT id, email, password, created FROM users WHERE email = ?");
		
		echo $mysqli->error;
		//asendan k�sim�rgi
		$stmt->bind_param("s", $email);
		
		//m��ran tulpadele muutujad
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		if ($stmt->fetch()) {
			//oli rida
			
			//v�rdlen paroole
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






?>