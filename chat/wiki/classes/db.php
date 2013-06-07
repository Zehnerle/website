<?php

	class DB {
	
		protected $server;
		protected $user;
		protected $password;
		protected $dbname;		
		
		// singleton instance 
		private static $instance;
		
		//Constructor for the class db
		public function __construct() {
			$this->server = 'localhost';
			$this->dbname = 'website';			
			$this->user = 'websiteuser';
			$this->password = 'ursinaty';
		}
		
		//get the full DB
		public static function getDB() {
		
			if(!isset(self::$instance)) {		
				self::$instance = new DB();
				self::$instance->connect();
			}
				
			return self::$instance;
		}
		
		//open a connection to the database
		public function connect() {
		
			//Connect to the Server
			$connection = mysql_connect($this->server, $this->user, $this->password) 
			or die("Verbindungsaufbau zu ". $this->server ." nicht m&ouml;glich!");
			
			//Connect to the Database
			mysql_select_db($this->dbname, $connection) 
			or die("Konnte die Datenbank ". $this->dbname . " nicht ausw&auml;hlen.");	

		}
		
		
		// QUERIES:
		
		public function totalNumber($table) {
			$query = mysql_query("SELECT COUNT(*) AS NUM FROM $table"); 			
			$row = mysql_fetch_assoc($query);
			return $row['NUM'];
		}
		
		public function select($ops, $table, $where) {						
			return mysql_query("SELECT $ops FROM $table $where"); 		
		}

		public function insert($table, $values) {	
			return mysql_query("INSERT INTO $table VALUES($values)");	
		}	

		public function update($table, $settings, $where) {	
			mysql_query("UPDATE $table SET $settings $where");	 		
		}	

		public function delete($table, $where) {						
			mysql_query("DELETE FROM $table $where");				
		}	
		
		public function query($query) {
			return mysql_query($query);
		}
		
	}

?>
