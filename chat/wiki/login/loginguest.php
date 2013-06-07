<?php
	
	if ($_SERVER['REQUEST_METHOD'] != 'POST') {
		session_start();

		$_SESSION['angemeldet'] = true;
		$_SESSION['user'] = "Visitor";
		
		header('Location: ../wiki.php');
		exit;
	}
?>
