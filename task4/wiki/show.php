<?php

	require_once("classes/article.php");
	require_once("classes/db.php");	
	require_once("classes/parser.php");
	
	include('templates/wikiheader.tpl.php');	
	
	showArticle();
	
	include('templates/wikifooter.tpl.php');	
	
	
	function showArticle() {	
	
		$title = urldecode($_GET['show']);
		
		// start measurement
		$time_start = microtime(true);
		
		$article = Article::getArticle()->select($title);
		$content = $article->content;
		$html = $article->html;//get the html code from the DB for optimizations
		// check if links are missing?		
		
		//if the normal content is get from the database, it has to be parsed
		//$parser = new Parser();
		//$html = $parser->parseToHtml($content);
		
		// end measurement
		$time_end = microtime(true);
		$time1 = round($time_end - $time_start, 6);
		$time1 = 'Content needed ' . $time1;
		
		// start measurement
		$time_start = microtime(true);
		
		$query = Article::getArticle()->selectLinks($title);

		if($query != FALSE) {	
		
			$links = "Linked by: ";
			
			while ($row = mysql_fetch_object($query)) {
				$links .= '<a href="show.php?show=' 
				. urlencode($row->title) . '">' . $row->title . '</a> ';
			}				
		}		
		
		// end measurement
		$time_end = microtime(true);
		$time2 = round($time_end - $time_start, 6);
		$time2 = 'Linklist needed ' . $time2;

		$urltitle = urlencode($title);
		$content = urlencode($content);
	
		include('templates/show.tpl.php');	

	}

?>

