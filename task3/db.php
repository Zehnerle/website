<?php

	class DB {
	
		protected $server;
		protected $user;
		protected $password;
		protected $dbname;
		protected $tablename;
		
		private static $instance;
	 
		public function __construct() {
			$this->server = 'localhost';
			$this->dbname = 'website';
			$this->tablename = 'article';
			$this->user = 'websiteuser';
			$this->password = 'ursinaty';
		}
		
		public static function getDB() {
		
			if(!isset(self::$instance)) {		
				self::$instance = new DB();
				self::$instance->connect();
			}
				
			return self::$instance;
		}
		
		public function connect() {
			$connection = mysql_connect($this->server, $this->user, $this->password) 
			or die("Verbindungsaufbau zu ". $this->server ." nicht m&ouml;glich!");
			
			mysql_select_db($this->dbname, $connection) 
			or die("Konnte die Datenbank ". $this->dbname . " nicht ausw&auml;hlen.");	

		}
		
		public function select() {						
			return mysql_query("SELECT * FROM " . $this->tablename); 		
		}
		
		public function selectArticle($query) {		
			return mysql_query("SELECT * FROM " . $this->tablename 
			. " WHERE title = '" . $query . "'");
		}		 
		
		public function insertArticle($title, $content) {
			mysql_query("INSERT INTO " . $this->tablename 
			. " VALUES('" . $title . "', '" . $content . "')");		
		}
		
		public function updateArticle($title, $content) {
			mysql_query("UPDATE " . $this->tablename 
			. " SET content = '" . $content . "' WHERE title = '" . $title . "'");		
		}
		
		public function deleteArticle($query) {	
			return mysql_query("DELETE FROM " . $this->tablename 
			. " WHERE title = '" . $query . "'");		
		}
	}

?>