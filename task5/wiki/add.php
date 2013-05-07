<?php
	include('login/auth.php');
	header('Content-Type: text/html; charset=utf-8');
	
	require_once("classes/article.php");
	require_once("classes/image.php");
	require_once("classes/db.php");
	require_once("classes/parser.php");
	
	include('login/loginbutton.php');
	include('templates/wikiheader.tpl.php');	
	
	if(isset($_POST['add']) || isset($_POST['imgchange'])) {
		addArticle("");	
	}
	
	else if(isset($_POST['create'])) {
		createArticle();		
	}		
	
	else if(isset($_POST['imgupload'])) {
		uploadImage();		
		addArticle("");			
	}
	
	
	else if(isset($_POST['imgdelete'])) {
		deleteImage();
		addArticle("");	
		
	}	
	
	include('templates/wikifooter.tpl.php');
	
	
	// FUNCTIONS
	
	function addArticle($error) {
		
		if(isset($_POST['imgchange'])) {
			$showImage = Image::getImage()->displayOldImage($_POST['image'], $_POST['alignment']);
			$showImage .= Image::getImage()->displayInputField();
		}
		else if(isset($_POST['image'])) 
			$showImage = Image::getImage()->displayImage($_POST['image'], $_POST['alignment']);
		else
			$showImage = Image::getImage()->displayInputField();
		
		include('templates/add.tpl.php');
		
	}
		

	function createArticle() {	
		
		if(isset($_SESSION['user'])){
			$owner = $_SESSION['user'];
		}
		
		$title = $_POST['title'];
		$error = "";
		
		if(!empty($title)) {
		
			$content = $_POST['content'];
			
			$parser = new Parser();
			$html = $parser->parseToHtml($content);
			$ownerid = $_SESSION['userid'];
				
			$article = Article::getArticle()->insert($title, $content, $html, $ownerid);		
				
			if($article != FALSE) {		
			
				if(isset($_POST['image']))
					insertImage($title);			
				$parser->insertLinks($title);
				$info = "Artikel '" . $title . "' eingef&uuml;gt!";
				header('Location: wiki.php?info=' . urlencode($info));
				
			} else
				$error = "Diesen Titel gibt es schon!<br />";
				
		}
		
		else $error = "Titel darf nicht leer sein!<br />";
		
		addArticle($error);	
		
	}

	
	function uploadImage() {
		
		// store as temporary image, rename later
		$temp = Image::getImage()->getTempImage();
		$image = insertTempImageIfValid();	
		
		if($image != $temp) {
			unset($_POST['image']);
			unset($_POST['alignment']);
		}
		else
			$_POST['image'] = $image;
	}
	
	
	function deleteImage() {
	
		$temp = Image::getImage()->getTempImage();
		Image::getImage()->removeImage($temp);
		unset($_POST['image']);
		unset($_POST['alignment']);
		
	}
	
	
	function insertTempImageIfValid() {
	
		$file = $_FILES['image'];	

		if(isset($file['tmp_name']) && $file['type']=="image/png"){				
			echo 'Bild gespeichert!';
			return Image::getImage()->storeTempImage($file['tmp_name']);				
		} 
		else {			
			echo 'Ung&uuml;ltiges Format!';
			return -1;
		}
	}	
	
	
	function insertImage($title)  {
		
		$alignment = $_POST['alignment'];
		
		$result = DB::getDB()->query("SELECT id 
			FROM article 
			WHERE title LIKE '$title'");
			
		$row = mysql_fetch_assoc($result);
		$id = $row['id'];
		$imagetitle = $id . ".png";

		$temp = Image::getImage()->getTempImage();	
		Image::getImage()->renameImage($temp, $imagetitle);
		Image::getImage()->insertImage($id, $alignment, $imagetitle);		

	}


?>
