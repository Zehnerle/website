<?php

class Parser {

	public function parse($string) {
		//Sucht und ersetzt einen regulären Ausdruck unter Verwendung eines Callbacks
		$parsed_string = preg_replace_callback("/\[\[.+\]\]/", array(&$this, 'rep_callback'), $string)."\n";
		$parsed_string = preg_replace_callback("/\---.+\---/", array(&$this, 'rep_title_callback'), $parsed_string)."\n";
		return 	$parsed_string;
	}
	
	// Callback function, berechnet die eingabe von Titeln
	public function rep_title_callback($match) {
		
		//substr(string $string , int $start [, int $length ] ) Gibt einen Teil eines Strings zurück. hier werden die beiden äußeren --- abgeschnitten
		$query = substr($match[0],3,-3);
		
		// Parsed zu einer h1 überschrift
		$title = '<h2>'.$query.'</h2>';
		return $title;
		
	}
	
	// Callback function, berechnet die eingabe von Links
	function rep_callback($match) {	
					
		$query = substr($match[0],2,-2);
		$link = $query;
		
		$abfrage = DB::getDB()->selectArticle($query);
		$db_Article = mysql_fetch_object($abfrage);
		
		if($db_Article != FALSE) {
			$link = '<a href="wiki.php?show=' . urlencode($query) . '">' . $query . '</a>';
		}
		
		return $link;		
	}
	
}
	
?>