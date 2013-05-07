<?php
	require_once("classes/paginator.php");
	require_once("classes/article.php");
	require_once("classes/db.php");

	include('templates/wikiheader.tpl.php');	
	
	// start measurement
	$time_start = microtime(true);
	
	search();
	
	// end measurement
	$time_end = microtime(true);
	$time = round($time_end - $time_start, 6);
	$time = 'Paginator needed ' . $time;
	
	include('templates/wikifooter.tpl.php');
	
	//this function searches for some titles or pices of titles
	function search() {
		
		$item = urldecode($_GET['searched']);//get the searched item
		$table = "article ";
		$where = "WHERE title LIKE '%$item%' "; //create query for DB to search for the item
		$query = $table . $where;
		$total = DB::getDB()->totalNumber($query);
	
		echo "<br />";
		
		//if no articles are found print message
		if($total == 0) {			
			echo "<strong>Nichts gefunden!</strong>";
			return;
		}		
		
		//create new paginator
		$paginator = new Paginator($total);
		
		$query = $paginator->getQuery();
		$where = $where . $query;
		$query = DB::getDB()->select("*", $table, $where);			
		
		//show all found articles
		while($article = mysql_fetch_object($query)){
			$title = $article->title;
			echo "<a href=show.php?show=".urlencode($title).">".$title."</a><br />" ;
		}		
		
		//display paginator
		$paginator->display("search.php", 'searched=' . $item .'&');
	
	}
	
	
?>
