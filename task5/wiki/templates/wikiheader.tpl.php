<?php include('pageheader.tpl.php');?>
		
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
