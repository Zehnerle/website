<?php
	include('login/auth.php');
	header('Content-Type: text/html; charset=utf-8');

	require_once("classes/generator.php");
	require_once("classes/article.php");
	require_once("classes/db.php");
	require_once("classes/parser.php");
	
	include('login/loginbutton.php');
	include('templates/wikiheader.tpl.php');		
	
	if(isset($_POST['generate'])) {
		generateArticles();	
	}
	
	else if(isset($_POST['clear'])) {
		deleteArticles();		
	} 
	
	else {
		include('templates/generate.tpl.php');
	}
	
	include('templates/wikifooter.tpl.php');
	
		
	function generateArticles() {
	
		$num = $_POST['number'];
		
		if(is_numeric($num) && $num <= 10000 && $num > 0) {			
			
			$generator = new Generator($num, 750);
			
			// start measurement
			$time_start = microtime(true);
			
			$generator->generate();	
			
			// end measurement
			$time_end = microtime(true);
			$time = round($time_end - $time_start, 6);
			$time = 'Generator needed ' . $time;	
			
			$error = "Neue Artikel generiert!";
		}
		
		else {
			$error = "Keine g&uuml;ltige Eingabe!";		
		}		

		include('templates/generate.tpl.php');
	}
	
	//this function deles all randomcreated Articles
	function deleteArticles() {
	
		// start measurement
		$time_start = microtime(true);
		
		$generator = new Generator();		
		$generator->deleteAll();

		// end measurement
		$time_end = microtime(true);
		$time = round($time_end - $time_start, 6);
		$time = 'Deleting all needed ' . $time;			
		
		$error = "Alle gel&ouml;scht!";	

		include('templates/generate.tpl.php');		
	}		
	
	
?>
