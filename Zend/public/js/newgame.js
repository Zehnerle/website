
/* Danke Gruppe 2! */


function reply_click(id) {
	var x = document.forms[0].choice1;
	x.value = id;
}
  
function submitCheck() {

	var returnval = true;
	var form = document.forms[0];
	
	if(form.player1.value === '') {
		returnval = false;
		player1 = form.player1.parentNode.parentNode;
		player1.setAttribute('class','control-group error');
		player1.childNodes[0].innerHTML = 'Player1 name field is missing!';
	} else {
		player1 = form.player1.parentNode;
		player1.setAttribute('class','');
		player1.parentNode.childNodes[0] = '';
	}
		   
	if(form.mail1.value === '' || !checkEmailFormat(form.mail1.value)) {
		returnval = false;
		mail1 = form.mail1.parentNode.parentNode;
		mail1.setAttribute('class','control-group error');
		mail1.childNodes[0].innerHTML = 'Player1 mail is missing';
	} else {
		mail1 = form.mail1.parentNode;
		mail1.setAttribute('class','');
		mail1.parentNode.childNodes[0]= '';

	}
	
	if(form.player2.value === '') {
		returnval = false;
		player2 = form.player2.parentNode.parentNode;
		player2.setAttribute('class','control-group error');
		player2.childNodes[0].innerHTML = 'Player2 name field is missing!';
	} else {
		player2 = form.player2.parentNode;
		player2.setAttribute('class','');
		player2.parentNode.childNodes[0] = '';
	}
	
	if(form.mail2.value === '' || !checkEmailFormat(form.mail2.value)) {
		returnval = false;
		mail2 = form.mail2.parentNode.parentNode;
		mail2.setAttribute('class','control-group error');
		mail2.childNodes[0].innerHTML = 'Player2 mail is missing';
	} else {
		mail2 = form.mail2.parentNode;
		mail2.setAttribute('class','');
		mail2.parentNode.childNodes[0]= '';
	}
	   
	if(form.choice1.value === undefined || form.choice1.value === '' || form.choice1.value === null ) {
		returnval = false;
		document.getElementById('weapons').innerHTML = 'Your choice is missing!';
	}
	
	return returnval;
}


function checkEmailFormat(email) {

	if(email.indexOf("@") === -1) {
		return false;
	}
	else {
		email = email.substring(email.indexOf("@") + 1);
		if(email.indexOf(".") === -1) {
			return false;
		}
		return true;
	}
}