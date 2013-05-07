<div class="logout" align="right">
				
	<p class="loginUser"><?php if(isset($username)) echo "Login as: ".$username; else echo "";?></p>
				
	<form action="login/logout.php" method="post" align="right">
	<input type="submit" value="Logout" />
	</form>
</div>
