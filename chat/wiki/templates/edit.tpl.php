<form method='post' action="<?php echo dirname($_SERVER['PHP_SELF']); ?>/edit.php" enctype="multipart/form-data">
	
	<p>
		Titel: <?php echo $_POST['title']; ?>
		<input type='hidden' name='title' value='<?php echo $_POST['title']; ?>' />
		<input type='hidden' name='id' value='<?php echo $_POST['id']; ?>' />
	</p>

	<p>
		Inhalt:* <br />
		<textarea name='content'><?php if(isset($_POST['content'])) echo $_POST['content']; ?></textarea>
		<br />
		<font class='annotation'>* Link Format: [[articletitle]] >>> Title Format: ---title---</font>
	</p>						
		
	<p>	Bild:  <br />
		<?php echo $showImage; ?>	
	</p>
		
	<p>
		<input type='submit' name='update' value='&Auml;nderungen &uuml;bernehmen' />
	</p>
	
</form>	

<p>
	<a href='<?php echo dirname($_SERVER['PHP_SELF']); ?>/wiki.php'>Zur&uuml;ck</a>
</p>



