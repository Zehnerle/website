
<p class="wikitime"><?php if(isset($time)) echo $time . ' s'; else echo "";?></p>
</div>
		</div>	
	
<?php 
require_once($_SERVER['DOCUMENT_ROOT'] . "/task.php");
$folder = Task::$task;
include($_SERVER['DOCUMENT_ROOT']."/".$folder.'/templates/pagefooter.tpl.php');
?>
