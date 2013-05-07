<?php
	include('login/auth.php');
	header('Content-Type: text/html; charset=utf-8');
	
	require_once("classes/article.php");
	require_once("classes/image.php");
	require_once("classes/db.php");	
	require_once("classes/parser.php");
	require_once("classes/user.php");
	
	include('login/loginbutton.php');
	include('templates/wikiheader.tpl.php');	
	
	showArticle();
	
	include('templates/wikifooter.tpl.php');	
	
	
	function showArticle() {	
	
		$title = urldecode($_GET['show']);
		
		// start measurement
		$time_start = microtime(true);
		
		$article = Article::getArticle()->select($title);	

		// end measurement
		$time_end = microtime(true);
		$time = round($time_end - $time_start, 6);
		$contenttime = 'Loading content needed ' . $time;
		
		//format timestamp
		$date = $article->modified;
		$split = explode(" ", $date); //Teilt einen String anhand einer Zeichenkette
		$unixDate = strtotime($split[0].$split[1]);//Wandelt englishes Textformat Datum in Unix-Timestamp um
		$modified = date("d.m.Y H:i", $unixDate);//Formatiert ein(e) angegebene(s) Ortszeit/Datum
		
		$ownerid = $article->owner;
		$owner = User::getUser()->getOwnerName($ownerid);
		$ownername = $owner->name;
		
		$modifiedbyid = $article->modifiedby;
		$modifier = User::getUser()->getModifierName($modifiedbyid);
		$modifiedby = $modifier->name;
		
		if($article == FALSE) {
			$info = "Artikel existiert nicht!";
			header('Location:' . dirname($_SERVER['PHP_SELF']) . '/wiki.php?info=' . $info);
		}
		
		$imagedisplay = showImage($article->image, $article->alignment);
		
		// start measurement
		$time_start = microtime(true);
		
		$links = showLinklist($title);
		
		// end measurement
		$time_end = microtime(true);
		$time = round($time_end - $time_start, 6);
		$time = 'Linklist needed ' . $time;
	
		include('templates/show.tpl.php');	

	}
	
	
	function showImage($image, $alignment) {
	
		$default = Image::getImage()->getDefaultImage();
		
		if($image != $default) {
			$path = Image::getImage()->getImagePath($image);
			return "<img src='" . $path . "' alt ='" . $image . "' style='float:" .  $alignment . "' class='showarticle' />";
		}
		
		return "";	
	}
	
	
	function showLinklist($title) {		
		
		$query = Article::getArticle()->selectLinks($title);

		if($query != FALSE) {	
		
			$links = "Linked by: ";
			
			while ($row = mysql_fetch_object($query)) {
				/*$links .= '<a href="show.php?show=' 
				. urlencode($row->title) . '">' . $row->title . '</a> ';*/
				$links .= '<a href="' . urlencode($row->title) . '">' . $row->title . '</a> ';
			}				
		}

		return $links;		
	}

?>

