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

    
	$a1 = new article('TITEL', 'VIIIEELLL TEEXXT');

	echo "{$a1->__getTitle()}<br>";
echo "\n";
	echo "{$a1->__getContent()}<br>";

	$a1->__setTitle('NEUERTITEL');
	$a1->__setContent('NEUER TEEEEEEEEEXXXXT');

	echo "{$a1->__getTitle()}<br>";
	echo "{$a1->__getContent()}<br>";
	
    //---------------------------------------------------
    //$title = $_GET['title'];
	//$content = $_GET['content'];
    
	//Instert Data into DB_TABLE
	//$sql = "INSERT INTO ".DB_TABLE." VALUES('$title', '$content')";
	//mysql_query($sql);
	
	//Get Data from the DB_TABLE
	$abfrage = "SELECT * FROM ".DB_TABLE."";
	$row = mysql_query($abfrage);
	while($artikel = mysql_fetch_object($row)){
	
		echo("Titel: {$artikel->title}<br>");
		echo("Content: {$artikel->content}<br>");
	}
			
?>

