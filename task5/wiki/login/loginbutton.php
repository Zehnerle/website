<?php
if($_SESSION['user'] != "Visitor"){
		$username = $_SESSION['user'];
		include('templates/logout.tpl.php');
	}
	else{
		$username = $_SESSION['user'];
		include('templates/loginbutton.tpl.php');
	}
?>
