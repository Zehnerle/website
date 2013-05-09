<div class="logout" align="right">
				
	<p class="loginUser"><?php if(isset($username)) echo "Login as: ".$username; else echo "";?></p>
				
	<form action="<?php echo dirname($_SERVER['PHP_SELF']); ?>/login/logout.php" method="post" align="right">
	<input type="submit" value="Logout" />
	</form>
</div>
