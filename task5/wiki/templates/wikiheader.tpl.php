<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">
	<head> 
		<title>Natis &amp; Ursis Webserver</title>
		<link rel="stylesheet" href="<?php echo dirname(dirname($_SERVER['PHP_SELF'])); ?>/style.css" type="text/css" />
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
		
		<div class="wikiblock">	
			<div class="wikinavi">	
			
				<a href='<?php echo dirname($_SERVER['PHP_SELF']); ?>/wiki.php' class='grey'>wikiStart</a><br/>
				<a href='<?php echo dirname($_SERVER['PHP_SELF']); ?>/generate.php' class='grey'>generator</a><br/>
							
				<p>
					<br/>
					<form method='post' action='<?php echo dirname($_SERVER['PHP_SELF']); ?>/search.php'>
						
						<input type='text' name='searched' class='search' />
						<br/><br/>
						<input type='submit' name='search' value='Suche' />	
						
					</form>
				</p>				

			</div>
			<div class="wikitext">
			<h1>Wiki</h1>
