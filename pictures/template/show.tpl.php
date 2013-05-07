<form method='get'>
	<p>
		Titel: <?php echo $title; ?>		
	</p> 
	
	<p>
		Inhalt: <br />
		<?php echo nl2br($content); ?>
		<input type='hidden' name='title' value='<?php echo $title; ?>'>
		<input type='hidden' name='content' value='<?php echo $content; ?>'>		
	</p>
	
	<p>
		<input type='submit' name='edit' value='Bearbeiten'> 
		<input type='submit' name='delete' value='L&ouml;schen'>
	</p>
	
	<p>
		<a href='wiki.php'>Zur&uuml;ck</a>
	</p>
</form>