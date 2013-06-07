<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/task.php");
$text = calcText();
$folder = Task::$task;?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		
		<title>Natis &amp; Ursis Webserver</title>
		<script src="/<?php echo $folder ?>/js/socket.io/<?php echo $socketio ?>" type="text/javascript"></script>
		<script src="/<?php echo $folder ?>/js/<?php echo $jsfile ?>" type="text/javascript"></script>
		
		<link rel="stylesheet" href="/<?php echo $folder ?>/style.css" type="text/css" />
		
	</head>

	<body>

		<div>
			<div class="right">
				<?php echo $text;?>
			</div>
			<div class="left">
				Natis &amp; Ursis Webserver
			</div>
		</div>

<?php 
function calcText(){

	$exp = explode('/',$_SERVER['PHP_SELF']);
	$actual = $scriptname=end($exp);
	
	switch ($actual) {
		case "index.php":
			return $text = "welcome";
		case "group.php":
			return $text = "group";
		case "exercises.php":
			return $text = "exercises";
		case "wiki.php" || "generate.php":
			return $text = "wiki";
		case "chat.php":
			return $text = "chat";
		case "links.php":
			return $text = "links";
		default:
			return $text = "";
	}
}
?>
