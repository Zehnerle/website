<form method='post' action='<?php echo dirname($_SERVER['PHP_SELF']); ?>/edit.php' enctype='multipart/form-data'> 
	
	<p class="articleinfo">
		Owner: <?php echo $ownername; ?><br \>
		Last modified: <?php echo $modified; ?><br \>
		Modified by: <?php echo $modifiedby; ?>
	</p>

	<p>
		Titel: <?php echo $title; ?>
	</p>

	<p>
		Inhalt: <br />
		<input type='hidden' name='id' value='<?php echo $article->id; ?>' />
		<input type='hidden' name='title' value='<?php echo $title; ?>' />
		<input type='hidden' name='content' value='<?php echo $article->content; ?>' />	
		<input type='hidden' name='image' value='<?php echo $article->image; ?>' />
		<input type='hidden' name='alignment' value='<?php echo $article->alignment; ?>' />
	</p>
		
	<table width='100%' style="border: 0px;">
		<tr>
			<td>
				<?php echo $imagedisplay; ?><?php echo $article->html; ?>
				
			</td>
		</tr>
	</table>	
	
	<p class="wikitime">
		<?php if(isset($contenttime)) echo $contenttime . ' s'; else echo "";?>
	</p>
	
	<p>
	<?php 
		if($_SESSION['user'] != "Visitor"){
			echo '<input type="submit" name="edit" value="Bearbeiten"> ';
			echo '<input type="submit" name="delete" value="L&ouml;schen">';
		}
	?>
	</p>
</form>

<p class="wikitime"><?php if(isset($links)) echo $links; else echo "";?><br />
<?php if(isset($time)) echo $time . ' s'; else echo "";?></p>
