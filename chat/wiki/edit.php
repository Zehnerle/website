<?php
	include('login/auth.php');
	header('Content-Type: text/html; charset=utf-8');

	require_once("classes/article.php");
	require_once("classes/image.php");
	require_once("classes/db.php");
	require_once("classes/parser.php");
	
	include('login/loginbutton.php');
	include('templates/wikiheader.tpl.php');		
	
	// case URL rewriting
	if(isset($_GET['title'])) {
		if(isset($_GET['delete'])) {
			$_POST['title'] = $_GET['title'];
			deleteArticle();
		}
		getArticle();	
		editArticle();
	}
	
	else if(isset($_POST['edit']) || isset($_POST['imgchange'])) {
		editArticle();	
	}
	
	else if(isset($_POST['update'])) {
		updateArticle();		
	} 
	
	else if(isset($_POST['delete'])) {
		deleteArticle();		
	}
	
	else if(isset($_POST['imgupload'])) {
		uploadImage();			
		editArticle();	
	}
	
	else if(isset($_POST['imgdelete'])) {
		deleteImage();
		editArticle();			
	}
	
	include('templates/wikifooter.tpl.php');


	
	// FUNCTIONS
	
	function getArticle() {
	
		$_POST['title'] = urldecode($_GET['title']);
		$article = Article::getArticle()->select($_POST['title']);
		$_POST['id'] = $article->id;
		$_POST['content'] = $article->content;
		$_POST['image'] = $article->image;
		$_POST['alignment'] = $article->alignment;
		
	}
	
	
	function editArticle() {	
	
		$defaultImage = Image::getImage()->getDefaultImage();

		if(isset($_POST['imgchange'])) {
			$showImage = Image::getImage()->displayOldImage($_POST['image'], $_POST['alignment']);
			$showImage .= Image::getImage()->displayInputField();
		}
		else if(isset($_POST['image']) && $_POST['image'] != $defaultImage)
			$showImage = Image::getImage()->displayImage($_POST['image'], $_POST['alignment']);
		else
			$showImage = Image::getImage()->displayInputField();
		
		include('templates/edit.tpl.php');
		
	}
	
	
	function updateArticle() {		
	
		$title = $_POST['title'];
		$content = $_POST['content'];
		
		$parser = new Parser();
		$html = $parser->parseToHtml($content);
		$parser->deleteLinks($title);
		$parser->insertLinks($title);
		
		$modifiedby = $_SESSION['userid'];
	
		Article::getArticle()->update($title, $content, $html, $modifiedby);
				
		$info = "Artikel '$title' bearbeitet!";

		header('Location:' . dirname($_SERVER['PHP_SELF']) . '/wiki.php?info=' . urlencode($info));		
		
	}
	
	
	function deleteArticle() {
	
		$info = "Artikel '" . $_POST['title'] . "' gel&ouml;scht!";	
		
		if(isset($_POST['image'])) 
			deleteImage();
		
		Article::getArticle()->delete($_POST['title']);
	
		header('Location:' . dirname($_SERVER['PHP_SELF']) . '/wiki.php?info=' . urlencode($info));
	}
	
	
	function uploadImage() {
	
		$result = insertImageIfValid();	
	
		if($result != "error")
			$_POST['image'] = $result;		
		
	}
	
	
	function insertImageIfValid() {
	
		$file = $_FILES['image'];
	
		if(isset($file['tmp_name']) && $file['type']=="image/png"){
			$imagename = Image::getImage()->storeImage(urldecode($_POST['id']), $file['tmp_name']);
			Image::getImage()->insertImage(urldecode($_POST['id']), $_POST['alignment'], $imagename);			
			echo 'Bild gespeichert!';
			return $imagename;
		} 
		else if(isset($_POST['alignment'])) {
			Image::getImage()->changeAlignment(urldecode($_POST['id']), $_POST['alignment']);
			echo 'Ausrichtung ge&auml;ndert!';
			return "error";
		}
		else {
			echo 'Ung&uuml;ltiges Format!';
			return "error";
		}
	}
	
	
	function deleteImage() {
	
		Image::getImage()->deleteImage($_POST['image']);
		Image::getImage()->removeImage($_POST['image']);
		unset($_POST['image']);
		unset($_POST['alignment']);
		
	}
	

?>
