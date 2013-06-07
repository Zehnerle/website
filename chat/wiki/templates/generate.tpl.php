<form method='POST' action='generate.php'>	

	<strong><?php if(isset($error)) echo $error; else echo ""; ?></strong>

	<p>
		Wieviele Zufallsartikel willst Du generieren?<br />
		Bitte Zahl > 0 und <= 10000 eingeben:
	</p>
	<p>
		<input type='text' name='number' class='search' />
	</p>
	<p>
		<input type='submit' name='generate' value='Generiere!'>
	</p>
	<p>	
		<br/>
	</p>
	<h3>Wieder l&ouml;schen?</h3>
	<p>	
		L&ouml;scht alle auto-generierten Artikel aus der Datenbank!
	</p>
	<p>
		<input type='submit' name='clear' value='Alle l&ouml;schen!'>
	</p>
</form>
<p class="wikitime"><?php if(isset($time)) echo $time . ' s'; else echo "";?></p>