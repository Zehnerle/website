<form method='get' action='edit.php'>
	<p>
		Titel: <?php echo $title; ?>		
	</p> 
	
	<p>
		Inhalt: <br />
		<?php echo $html; ?>
		<input type='hidden' name='title' value='<?php echo $urltitle; ?>'>
		<input type='hidden' name='content' value='<?php echo $content; ?>'>		
	</p>
	
	<p class="wikitime">
	<?php if(isset($time1)) echo $time1 . ' s'; else echo "";?></p>
	
	<p>
		<input type='submit' name='edit' value='Bearbeiten'> 
		<input type='submit' name='delete' value='L&ouml;schen'>
	</p>
</form>

<p class="wikitime"><?php if(isset($links)) echo $links; else echo "";?><br />
<?php if(isset($time2)) echo $time2 . ' s'; else echo "";?></p>
