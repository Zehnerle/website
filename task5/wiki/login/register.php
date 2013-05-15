<?php
	
	require_once("../classes/db.php");
	require_once("../classes/user.php");
	
	$username = $_POST["username"];
	$password = $_POST["passwort"];
	$password2 = $_POST["passwort2"];

	if($username == '' || $password == '' || strlen($password) < 6){
		$error_reg = "Eingabe ung&uuml;ltig!";
	}
	else{
		if ($password == $password2){
			
			if(!(User::getUser()->select($username))){ //wenn username noch nicht gespeichert ist
			
			User::getUser()->insert($username, $password);
			$error_reg = "Registrierung erfolgreich!";
			}
			else{
				$error_reg = "Benutzername existiert bereits!";
			}
		}
		else{
			$error_reg = "Passw&ouml;rter stimmen nicht &uuml;berein!";
		}
	}
	
	include('templates/login.tpl.php');
	include('../templates/wikifooter.tpl.php');
?>
