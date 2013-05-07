<?php
require_once("article.php");

    //Zugangsdaten als Konstanten
    define('DB_HOST','localhost');
    define('DB_USER','websiteuser');
    define('DB_PASSWORD','ursinaty');
    define('DB_NAME','website');
    define('DB_TABLE','article');

    //Verbindung zum Datenbank-Server aufbauen
    $connection=mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) or die("Verbindungsaufbau zu ".DB_HOST." nicht m&ouml;glich!");

    //Datenbank auswählen
    mysql_select_db(DB_NAME, $connection) or die("Konnte die Datenbank ".DB_NAME." nicht ausw&auml;hlen.");
	
	//Start new session		
	session_start();
	
	//Call function timing
	timing();
	
	
	if (!isset($_SESSION['wiki'])) {
		$_SESSION['wiki'] = array();
	} 	
	
	if(isset($_GET['add']) || isset($_GET['edit'])) {
		editArticle();	
	}
	
	else if(isset($_GET['create'])) {
		createArticle();		
	}
	
	else if(isset($_GET['show'])) {
		showArticle();		
	}
	
	else if(isset($_GET['delete'])) {
		deleteArticle();
	}
	
	else {
		mainsite();
	}
			
	
	//Function timing
	function timing() {
		
		$now = time();	
		$timeout = 60;	// 60 seconds
		
		 if(isset($_SESSION['timeout'])) {
		 
			$duration = $now - (int)$_SESSION['timeout'];
			
			if($duration > $timeout) {			
				session_destroy();
				session_start();
			}
		
		}		
			
		$_SESSION['timeout'] = $now;
	
	}	
		
	//This function creates a new Article
	function createArticle() {
			
		$title = $_GET['title'];
		$content = $_GET['content'];
    
		//Instert Data into DB_TABLE
		$sql = "INSERT INTO ".DB_TABLE." VALUES('$title', '$content')";
		mysql_query($sql);
		
		$index = -1;
		$articles = array();
		
		// check if article already exists
		foreach($_SESSION['wiki'] as  $key => $value) {
			if($value['title'] == $_GET['title'])
				$index = $key;
		}
		
		if($index == -1) {
			// add new article
			$articles['title'] = $_GET['title'];
			$articles['content']  = $_GET['content'];
			// add element at the end of the array
			array_push($_SESSION['wiki'], $articles);
		} else {
			// overwrite edited article
			$_SESSION['wiki'][$index]['title'] = $_GET['title'];
			$_SESSION['wiki'][$index]['content'] = $_GET['content'];
		}
		
		goback();
	}	
		
	//This function edits a existing Article
	function editArticle() {		

		if (!isset($_GET['item'])) {
			// show empty input field for new article
			$title = "";
			$content = "";
		}
		else {
			// show input field of existing article
			$item = $_GET['item'];
			$title = $_SESSION['wiki'][$item]['title'];
			$content = $_SESSION['wiki'][$item]['content'];
		}		
		
		echo "<form method='get'>
				<p>
					Titel: <br />
					<input type='text' name='title' value='"
					. $title
					. "' style='width: 300px; height: 20px;' />
				</p>

				<p>
					Inhalt:* <br />
					<input type='text' name='content' value='"
					. $content
					. "' style='width: 300px; height: 20px;' />
					<br />
					<font class='annotation'>* Link Format: [articletitle]</font>
				</p>						
						
				<p>
					<input type='submit' name='create' value='Ok' />
				</p>

				<p>
					<a href='wiki.php'>Zur&uuml;ck</a>
				</p>
			</form>";		
	
	}
		
	//This function shows the Article
	function showArticle() {		
	
		$item = $_GET['show'];
		
		$title = $_SESSION['wiki'][$item]['title'];
		
		// replace bracket links by html links
		$content = parse($_SESSION['wiki'][$item]['content']);
	
	echo "<form method='get'>
				<p>
					Titel: <br />" 
					. $title
					. "
				</p> 
				
				<p>
					Inhalt: <br />" 
					. $content
					. "<input type='hidden' name='item' value='$item'> 
				</p>
				
				<p>
					<input type='submit' name='edit' value='Bearbeiten'> 
					<input type='submit' name='delete' value='L&ouml;schen'>
				</p>
				
				<p>
					<a href='wiki.php'>Zur&uuml;ck</a>
				</p>
			</form>";
	}
	
	
	function parse($string) {
		//Sucht und ersetzt einen regulären Ausdruck unter Verwendung eines Callbacks
		$parsed_string = preg_replace_callback("/\[.+\]/U", "rep_callback", $string)."\n";
		$parsed_string = preg_replace_callback("/\---.+\---/U", "rep_title_callback", $parsed_string)."\n";
		return 	$parsed_string;
	}
	
	// Callback function, berechnet die eingabe von Titeln
	function rep_title_callback($match) {
		
		//substr(string $string , int $start [, int $length ] ) Gibt einen Teil eines Strings zurück. hier werden die beiden äußeren --- abgeschnitten
		$query = substr($match[0],3,-3);
		
		// Parsed zu einer h1 überschrift
		$title = '<h1>'.$query.'</h1>';
		return $title;
		
	}
	
	// Callback function, berechnet die eingabe von Links
	function rep_callback($match) {	
					
		$index = -1;
		//substr(string $string , int $start [, int $length ] ) Gibt einen Teil eines Strings zurück. hier werden die beiden äußeren klammern abgeschnitten
		$query = substr($match[0],1,-1);
		
		foreach($_SESSION['wiki'] as  $key => $value) {
			if($value['title'] == $query)
				$index = $key;
		}
			
		if($index == -1) return $query;
		
		// urlencode(): URL-kodiert einen String
		$index = urlencode($index);
		$link = '<a href="wiki.php?show='.$index.'">'.$match[0].'</a>';
		return $link;
		
	}
	
	//This function eliminates an Article
	function deleteArticle() {
		$item = $_GET['item'];	
		unset($_SESSION['wiki'][$item]);
		
		goback();
	}
	
	
	function mainsite() {
		echo "<form method='get'>
				<p>
					Deine Artikel: <br />
					<input type='hidden' name='show'>";
					
					foreach($_SESSION['wiki'] as  $key => $value) {
						echo  "<a href=wiki.php?show=" . $key . ">" 
							. $value['title']
							. "</a><br />";
					}
					
		echo "		<br />
					<input type='submit' name='add' value='Neuer Artikel'>
				</p>
			</form>";
	}
	
	//This function goes back to the wiki.php page
	function goback() {
		header('Location: wiki.php');
	}
	
?>
	
