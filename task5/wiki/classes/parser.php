<?php

class Parser {

	private $links;
	private $linkCount;

	//Constructor for the class parser
	public function __construct() {
		$this->links = array();
	}

	public function parseToHtml($content) {	
		$this->links = array();
		$this->linkCount = 0;
		$html = $this->parse($content);
		return nl2br($html);
	}

	private function parse($string) {
		$string = preg_replace_callback("/\[\[.+\]\]/U", 
			array(&$this, 'rep_links_callback'), $string);
		$string = preg_replace_callback("/\---.+\---/U", 
			array(&$this, 'rep_title_callback'), $string);
		return 	$string;
	}
	
	// Callback function, berechnet die eingabe von Links
	private function rep_links_callback($match) {	
		
		$query = substr($match[0],2,-2);

		$db_Article = Article::getArticle()->select($query);
		
		if($db_Article != FALSE) {
			$query = ' <a href="' . urlencode($query) . '">' . $query . '</a> ';
			$this->links[$this->linkCount] = $db_Article;
			$this->linkCount++;
		}
		
		return $query;		
	}
	
	
	// Callback function, berechnet die eingabe von Titeln
	private function rep_title_callback($match) {
		
		$query = substr($match[0],3,-3);		
		$title = '<h2>'.$query.'</h2>';
		return $title;
		
	}	
	
	public function deleteLinks($from) {		
		Article::getArticle()->deleteLinks($from);
	}
	
	public function insertLinks($from) {

		$query = DB::getDB()->query("SELECT id FROM article WHERE title LIKE '$from'");
		$row = mysql_fetch_assoc($query);
		
		foreach ($this->links as $value) {
			Article::getArticle()->insertLink($row['id'], $value->id);
		}
	}
	
	public function returnLinksArray($from) {
	
		$links = array();
		$i = 0;
		
		// 2 dim articles array with from-title and to-id
		foreach ($this->links as $value) {
			$links[$i][0] = $from;
			$links[$i][1] = $value->id;
			$i++;
		}
		
		return $links;
	}	
}
	
?>
