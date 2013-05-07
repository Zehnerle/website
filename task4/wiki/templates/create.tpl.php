<form method='get'>

	<?php echo $error; ?>
	
	<p>
		Titel: <?php echo $title; ?>
	</p>

	<p>
		Inhalt:* <br />
		<textarea type='text' name='content' /><?php echo $content; ?></textarea>
		<br />
		<font class='annotation'>* Link Format: [[articletitle]] >>> Title Format: ---title---</font>
	</p>						
			
	<p>
		<input type='submit' name='<?php echo $action; ?>' value='Ok' />
	</p>

	<p>
		<a href='wiki.php'>Zur&uuml;ck</a>
	</p>
</form>
