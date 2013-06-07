<?php
	include('login/auth.php');
	header('Content-Type: text/html; charset=utf-8');

	require_once("classes/article.php");
	require_once("classes/db.php");	
	require_once("classes/paginator.php");
	require_once("classes/user.php");
	
	include('login/loginbutton.php');
	include('templates/wikiheader.tpl.php');
	
	// start measurement (1)
	$time_start = microtime(true);
	
	mainsite();	
	
	// end measurement (2)
	$time_end = microtime(true);
	$time = round($time_end - $time_start, 6);
	$time = 'Paginator needed ' . $time;
	
	include('templates/wikifooter.tpl.php');		
	
	
	function mainsite() {	
	
		// info message when inserted or updated article
		$info = "";		
		if (isset($_GET['info'])) {
			$info = '<strong>' . urldecode($_GET['info']) . '<br /></strong>';
		}			
		
		include('templates/mainheader.tpl.php');
		
		//setup paginator
		$total = Article::getArticle()->totalNumber();	
		$paginator = new Paginator($total);
		
		// display article links
		$query = $paginator->getQuery();
		$query = Article::getArticle()->selectSimple($query);			

		if($query != FALSE) {
			while($article = mysql_fetch_object($query)){
				$title = $article->title;
				//echo "<a href=show.php?show=".urlencode($title).">".$title."</a><br />";
				echo "<a href='" . urlencode($title). "'>" . $title. "</a><br />";
			}		
			
			// display paginator
			$paginator->display("", "");
		}
		
		if($_SESSION['user'] != "Visitor"){
			include('templates/mainfooter.tpl.php');
		}
	}		
	
?>
	
