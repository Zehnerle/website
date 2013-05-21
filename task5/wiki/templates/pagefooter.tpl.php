		<div class="navigation">
		<?php
		require_once("/var/www/task.php");
		
				$folder = Task::$task;
				$actual = $scriptname=end(explode('/',$_SERVER['PHP_SELF']));
				$index = '';
				$group = '';
				$exercises = '';
				$wiki = '';
				$links = '';
				
				switch ($actual) {
					case "index.php":
						$index = 'actual';
						break;
					case "group.php":
						$group = 'actual';
						break;
					case "exercises.php":
						$exercises = 'actual';
						break;
					case "links.php":
						$links = 'actual';
						break;
					case ("wiki.php" || "generate.php"):
						$wiki = 'actual';
						break;
					default:
						break;
				}
				
				echo "<a href='/".$folder."/index.php' class='navigation ".$index."'>home</a>";
				echo "<a href='/".$folder."/group.php' class='navigation ".$group."'>group</a>";
				echo "<a href='/".$folder."/exercises.php' class='navigation ".$exercises."'>exercises</a>";
				echo "<a href='/".$folder."/wiki.php' class='navigation ".$wiki."'>wiki</a>";
				echo "<a href='/Zend' class='navigation'>game</a>";
				echo "<a href='https://github.com/Zehnerle/website' class='navigation'>github</a>";
				echo "<a href='/".$folder."/links.php' class='navigation ".$links."'>links</a>";
		?>
		</div>
	</body>
</html>
