<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require_once("db.php");
	require_once("article.php");
	require_once("parser.php");
	
	
	if(isset($_GET['add'])) {
		addArticle("", "");	
	}
	
	else if(isset($_GET['create'])) {
		createArticle();		
	}
	
	else if(isset($_GET['edit'])) {
		editArticle();	
	}
	
	else if(isset($_GET['update'])) {
		updateArticle();	
	}
	
	else if(isset($_GET['show'])) {
		showArticle();		
	}
	
	else if(isset($_GET['delete'])) {
		$info = "<br />Artikel gel&ouml;scht!<br/>";
		DB::getDB()->deleteArticle($_GET['title']);		
		mainsite($info);
	}
	
	else {
		$info = "";
		mainsite($info);
	}			
		
			
	function addArticle($error, $content) {	
	
		$title = "<br />
		<textarea type='text' name='title' class='title' /></textarea>";	
		$action = "create";
		include('template/create.tpl.php');
		
	}
		

	function createArticle() {	
		
		if($_GET['title'] != '') {
		
			$query = DB::getDB()->selectArticle($_GET['title']);
			$db_article = mysql_fetch_object($query);
		
			if($db_article == FALSE) {
				DB::getDB()->insertArticle($_GET['title'], $_GET['content']);	
				$info = "<br />Artikel eingef&uuml;gt!<br />";
				mainsite($info);
				return;
			} else {
				$error = "Diesen Titel gibt es schon!<br />";
			}			
		}
		
		else $error = "Titel darf nicht leer sein!<br />";		
		addArticle($error, $_GET['content']);	
		
	}
	
	
	function editArticle() {	
		
		$title = $_GET['title'];

		$query = DB::getDB()->selectArticle($title);
		$db_Article = mysql_fetch_object($query);
		$content = $db_Article->content;
		
		$title = $title
			. "<input type='hidden' name='title' value='" . $title . "'>";			
		$error = "";
		$action = "update";
		include('template/create.tpl.php');
		
	}
	
	
	function updateArticle() {		
	
		DB::getDB()->updateArticle($_GET['title'], $_GET['content']);
		$info = "<br />Artikel bearbeitet!<br/>";
		mainsite($info);
		
	}
		

	function showArticle() {		
	
		$title = $_GET['show'];
		
		//Sql query to get the content
		$query = DB::getDB()->selectArticle($title);
		$db_Article = mysql_fetch_object($query);
		$db_content = $db_Article->content;
		
		// replace bracket links by html links
		$parser = new Parser();
		$content = $parser->parse($db_content);
	
		include('template/show.tpl.php');	

	}
	
	//Creats the main wiki page, with a list of all stored Articles in the DB and the button for creating a new Article
	function mainsite($info) {
	
		include('template/mainheader.tpl.php');	
					
		$query = DB::getDB()->select();					
		while($article = mysql_fetch_object($query)){
			$title = $article->title;
			echo "<a href=wiki.php?show=".urlencode($title).">".$title."</a><br />" ;
		}
					
		include('template/mainfooter.tpl.php');
		
	}
	
	function br2nl($text) {
		return  preg_replace('/<br\\s*?\/??>/i', '', $text);
	}
	
?>
	
