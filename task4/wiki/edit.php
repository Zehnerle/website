<?php

	require_once("classes/article.php");
	require_once("classes/db.php");
	require_once("classes/parser.php");
	
	include('templates/wikiheader.tpl.php');	
	
	if(isset($_GET['edit'])) {
		editArticle();	
	}
	
	else if(isset($_GET['update'])) {
		updateArticle();		
	} 
	
	else if(isset($_GET['delete'])) {
		deleteArticle();		
	}
	
	include('templates/wikifooter.tpl.php');


	function editArticle() {	
		
		$title = urldecode($_GET['title']);
		echo $title;
		$content = urldecode($_GET['content']);
		
		$title = $title
			. "<input type='hidden' name='title' value='" . urlencode($title) . "'>";			
		$error = "";
		$action = "update";
		include('templates/create.tpl.php');
		
	}
	
	
	function updateArticle() {		
	
		$title = urldecode($_GET['title']);
		$content = urldecode($_GET['content']);
		
		$parser = new Parser();
		$html = $parser->parseToHtml($content);
		$parser->deleteLinks($title);
		$parser->insertLinks($title);
	
		Article::getArticle()->update($title, $content, $html);
				
		$info = "Artikel '$title' bearbeitet!";

		header('Location: wiki.php?info=' . urlencode($info));		
		
	}
	
	
	function deleteArticle() {
	
		$title = urldecode($_GET['title']);
		$info = "Artikel gel&ouml;scht!";
		
		Article::getArticle()->delete($title);
		
		// update html codes of all elements that linked here
	
		header('Location: wiki.php?info=' . urlencode($info));
	}

?>