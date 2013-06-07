<?php

class User {

	private $username;
	private $password;
	
	// singleton instance
	private static $instance;
	
	//Constructor for the class article
	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
		$this->tablename = 'user';
	}
	
	//get the full Article
	public static function getUser() {
		//if $instance isn't already set return a new Article with empty attributes otherwise return the instance
		if(!isset(self::$instance)) {//self:: wird die aktuelle Klasse angesprochen
			self::$instance = new User("", "");
		}
		//return the instance if it is set
		return self::$instance;
	}
	
	//get the Title of the Article
	public function getUsername() {
		return $this->username;
	}
	
	//get the Content of the Article
	public function getPassword() {
		return $this->password;
	}

	
	// QUERIES: 
	
	public function totalNumber() {
		return DB::getDB()->totalNumber($this->tablename);
	}
		
	public function selectSimple($settings) {
		return DB::getDB()->select("*", $this->tablename, $settings);
	}
	
	public function select($username) {
		$query = DB::getDB()->select("*", $this->tablename, " WHERE name LIKE '$username'");
		return mysql_fetch_object($query);
	}		 
	
	public function insert($name, $password) {	
		$prefix = $this->tablename . "(name, password)";
		return DB::getDB()->insert($prefix, "'$name', sha1('".$name.$password."')");
	}
	
	public function update($name, $password, $html) {
		DB::getDB()->update($this->tablename, " password = sha1('".$name.$password."')", " WHERE name LIKE '$name'");
	}
	
	public function delete($title) {	
		DB::getDB()->delete($this->tablename, " WHERE name = '$name'");		
	}
	
	//OWNER QUERIES:
	public function getOwnerName($id){
		return mysql_fetch_object(
			DB::getDB()->query("
			SELECT DISTINCT name 
			FROM user AS u 
			INNER JOIN article
			WHERE article.owner=u.id AND u.id LIKE '$id'")
		);
	}
	
	public function getModifierName($id){
		return mysql_fetch_object(
			DB::getDB()->query("
			SELECT DISTINCT name 
			FROM user AS u 
			INNER JOIN article
			WHERE article.modifiedby=u.id AND u.id LIKE '$id'")
		);
	}
	
}
?>
