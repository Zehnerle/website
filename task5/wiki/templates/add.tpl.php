<form method='post' action="<?php echo "add.php" ?>" enctype="multipart/form-data">

	<?php echo $error; ?>
	
	<p>
		Titel:<br />
		<textarea name='title' class='title'><?php if(isset($_POST['title'])) echo $_POST['title']; ?></textarea>
	</p>

	<p>
		Inhalt:* <br />
		<textarea name='content' /><?php if(isset($_POST['content'])) echo $_POST['content']; ?></textarea>
		<br />
		<font class='annotation'>* Link Format: [[articletitle]] >>> Title Format: ---title---</font>
	</p>		
	
	<p>		
		Bild (*.png): <br />
		<?php echo $showImage; ?>	
	</p>
		
	<p>
		<input type='submit' name='create' value='Artikel erstellen' />
	</p>
	
</form>

<p>
	<a href='wiki.php'>Zur&uuml;ck</a>
</p>



