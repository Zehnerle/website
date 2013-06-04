function getPath() {
	return 'http://' + document.location.hostname 
			+ '/' + location.pathname.split('/')[1] + '/game';
}


function weaponInfo(choice, site) {

	var pre = "<strong>Deine Wahl: ";
	var text;
	
	if(choice == 1)
		text = pre + "ROCK / STEIN:</strong><br>BESIEGT Schere und Echse<br>VERLIERT GEGEN Papier und Spock";
	else if(choice == 2)
		text = pre + "PAPER / PAPIER:</strong><br>BESIEGT Stein und Spock<br>VERLIERT GEGEN Schere und Echse";
	else if(choice == 3)
		text = pre + "SCISSORS / SCHERE:</strong><br>BESIEGT Papier und Echse<br>VERLIERT GEGEN Stein und Spock";
	else if(choice == 4)
		text = pre + "SPOCK:</strong><br>BESIEGT Stein und Schere<br>VERLIERT GEGEN Papier und Echse";
	else if(choice == 5)	
		text = pre + "LIZARD / ECHSE:</strong><br>BESIEGT Papier und Spock<br>VERLIERT GEGEN Stein und Schere";
		
	$(site + ' #weaponinfo').html(text).show();
};

function hideWeaponInfo() {
	$('#weaponinfo').hide();
}

//Check if Emailformat is valid
function checkEmailFormat(email) {
	var strReg = "^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$";
	var regex = new RegExp(strReg);
	  return(regex.test(email)); 
}

//Check if Playerformat is valid
function checkPlayerFormat(player) {
	if(player.length < 3 || player.length > 10){
		return false;
	}
	return true;
}

function weaponCheck(value, field) {

	var weaponerror = "Keine Waffe gew&auml;hlt!";
	
	if(value === '') {
		field.html(weaponerror).show();
		return false;
	}else{
		field.hide();
	}
	return true;
}

function playerCheck(value, field) {

	var emptyerror = "Feld darf nicht leer sein!";
	var wrongplayererror = "Spielername muss zwischen 3 und 10 Zeichen lang sein!";

	if(value === '') {
		field.html(emptyerror).show();
		return false;
	} else if(!checkPlayerFormat(value)) {
		field.html(wrongplayererror).show();
		return false;
	} else {
		field.hide();
	}

	return true;

}


function mailCheck(value, field) {

	var emptyerror = "Feld darf nicht leer sein!";
	var wrongformaterror = "Das ist keine g&uuml;ltige E-Mail-Adresse!";

	if(value === '') {
		field.html(emptyerror).show();
		return false;
	} else if(!checkEmailFormat(value)) {
		field.html(wrongformaterror).show();
		return false;
	} else
		field.hide();

	return true;

}
