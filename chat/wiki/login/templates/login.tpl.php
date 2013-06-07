<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">
	<head> 
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />		
		<title>Natis &amp; Ursis Webserver</title>
		<link rel="stylesheet" href="../../style.css" type="text/css" />
	</head>
	
	<body>
		
		<div>
			<div class="right">
				wiki
			</div>
			<div class="left">
				Natis &amp; Ursis Webserver
			</div>
		</div>
		
		<div class="block" align="center">
			
			<div class="login" align="center">
				
				<h1>Login</h1>
				<p>
				<form action="login.php" method="post">
				Username: <br />
				<input type="text" name="username" value='' size="15"/><br /><br />
				Passwort: <br />
				<input type="password" name="password" value='' size="15"/><br />
				<br />
				<strong><?php if(isset($error_login)) echo $error_login; else echo ""; ?></strong>
				<br /><br />
				<input type="submit" value="Anmelden" />
				</form>
				</p>
				
			</div>
			
			<?php include('register.tpl.php'); ?>
			
		</div>
		
	</body>
</html>
