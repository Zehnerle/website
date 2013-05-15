<div class="register" align="center">
				
			<h1>Registrieren</h1>
			<p>
				<form action="register.php" method="post">
				Username:<br />
				<input type="text" size="15" maxlength="50"
				name="username" value=''><br /><br />

				Passwort:<br />
				<input type="password" size="15" maxlength="50"
				name="passwort" value=''><br />
				<font class='annotation'>* min. 6 Zeichen</font><br /><br />

				Passwort wiederholen:<br />
				<input type="password" size="15" maxlength="50"
				name="passwort2" value=''><br />

				<br />
				<strong><?php if(isset($error_reg)) echo $error_reg; else echo ""; ?></strong>
				<br /><br />

				<input type="submit" value="Registrieren">
				</form>
			</p>
</div>
