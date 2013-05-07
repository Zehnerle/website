<?php

class Article {

	private $title;
	private $content;
	private $tablename;

	
	// singleton instance
	private static $instance;
	
	//Constructor for the class article
	public function __construct($title, $content) {
		$this->title = $title;
		$this->content = $content;
		$this->tablename = 'article';
	}
	
	//get the full Article
	public static function getArticle() {
		//if $instance isn't already set return a new Article with empty attributes otherwise return the instance
		if(!isset(self::$instance)) {//self:: wird die aktuelle Klasse angesprochen
			self::$instance = new Article("", "");
		}
		//return the instance if it is set
		return self::$instance;
	}
	
	//get the Title of the Article
	public function getTitle() {
		return $this->title;
	}
	
	//get the Content of the Article
	public function getContent() {
		return $this->content;
	}

	
	// QUERIES: 
	
	public function totalNumber() {
		return DB::getDB()->totalNumber($this->tablename);
	}
		
	public function selectSimple($settings) {
		return DB::getDB()->select("*", $this->tablename, $settings);
	}
	
	public function select($title) {
		$query = DB::getDB()->select("*", $this->tablename, " WHERE title LIKE '$title'");
		return mysql_fetch_object($query);
	}		 
	
	public function insert($title, $content, $html) {	
		$prefix = $this->tablename . "(title, content, html)";
		return DB::getDB()->insert($prefix, "'$title', '$content', '$html'");
	}
	
	public function insertGenerated($html) {	
		$prefix = $this->tablename . '(title, content, html, generated)';
		return DB::getDB()->insert($prefix, "'$this->title', '$this->content', '$html', 1");
	}
	
	public function update($title, $content, $html) {
		DB::getDB()->update($this->tablename, " content = '$content', html = '$html'", " WHERE title LIKE '$title'");
	}
	
	public function delete($title) {	
		DB::getDB()->delete($this->tablename, " WHERE title = '$title'");		
	}
	
	
	// LINK QUERIES:
	
	public function selectLinks($title) {
		return DB::getDB()->query("SELECT title 
			FROM article AS a INNER JOIN links as l
			ON a.id = l.from
			WHERE l.to IN
			(SELECT id FROM article WHERE title LIKE '$title')");
	}
	
	
	public function insertLink($id1, $id2) {		
		DB::getDB()->query("INSERT INTO links(`from`, `to`) VALUES('$id1', '$id2')");		
	}
	
	public function deleteLinks($title) {
		DB::getDB()->query("DELETE FROM links WHERE links.from IN
			(SELECT id FROM article WHERE title LIKE '$title')");
	}
	
}
?>
