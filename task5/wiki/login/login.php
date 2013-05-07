<?php
	
	require_once("../classes/db.php");
	require_once("../classes/user.php");
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		session_start();

		$username = $_POST['username'];
		if(!isset($username)){
			$username = "Gast";
		}
		
		$password = $_POST['password'];
		$passwordcrypt = sha1($username.$password);
		
		$userfromDB = User::getUser()->select($username);
		if($userfromDB == false){
			$error_login = "Benutzername existiert nicht!";
		}
		else{
			
			$useridfromDB = $userfromDB->id;
			$usernamefromDB = $userfromDB->name;
			$passwordfromDB = $userfromDB->password;

			// Benutzername und Passwort werden überprüft
			if ($username == $usernamefromDB && $passwordcrypt == $passwordfromDB) {
				$_SESSION['angemeldet'] = true;
				$_SESSION['userid'] = $useridfromDB;
				$_SESSION['user'] = $username;
				
				header('Location: ../wiki.php');
				exit;
			}
			else{
					$error_login = "Benutzername oder Passwort ung&uuml;ltig!";
			}
		}
	}
	
	include('templates/login.tpl.php');
	include('../templates/wikifooter.tpl.php');
?>
