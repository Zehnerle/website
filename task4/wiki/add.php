<?php
	
	require_once("classes/article.php");
	require_once("classes/db.php");
	require_once("classes/parser.php");

	include('templates/wikiheader.tpl.php');	
	
	if(isset($_GET['add'])) {
		addArticle("","");	
	}
	
	else if(isset($_GET['create'])) {
		createArticle();		
	}
	
	include('templates/wikifooter.tpl.php');
	
	
	function addArticle($error, $content) {	
		$title = "<br />
		<textarea type='text' name='title' class='title' /></textarea>";	
		$action = "create";
		include('templates/create.tpl.php');
	}
		

	function createArticle() {	
		
		$title = urldecode($_GET['title']);		
		
		if(!empty($title)) {
		
			$content = urldecode($_GET['content']);
			
			$parser = new Parser();
			$html = $parser->parseToHtml($content);
				
			$article = Article::getArticle()->insert($title, $content, $html);						
				
			if($article != FALSE) {			
				$parser->insertLinks($title);
				$info = "Artikel eingef&uuml;gt!";
				header('Location: wiki.php?info=' . urlencode($info));
			} else {
				$error = "Diesen Titel gibt es schon!<br />";
			}			
		}
		
		else $error = "Titel darf nicht leer sein!<br />";		
		addArticle($error, $_GET['content']);	
		
	}	


?>