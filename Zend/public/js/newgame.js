
/* von Gruppe 2 ausgeliehen */


function reply_click(id) {
	var x = document.forms[0].choice1;
	x.value = id;
}
  
function submitCheck() {

	var returnval = true;
	var form = document.forms[0];
	
	if(form.player1.value === ''){
		returnval = false;
		form.player1.parentNode.parentNode.setAttribute('class','control-group error');
		var s = form.player1.parentNode.parentNode.childNodes[0];
		s.innerHTML = 'Player1 name field is missing!';
	} else {
		form.player1.parentNode.setAttribute('class','');
		form.player1.parentNode.parentNode.childNodes[0] = '';
	}
	
	if(form.player2.value === ''){
		returnval = false;
		form.player2.parentNode.parentNode.setAttribute('class','control-group error');
		var s = form.player2.parentNode.parentNode.childNodes[0];
		s.innerHTML = 'Player2 name field is missing!';
	} else{
		form.player2.parentNode.setAttribute('class','');
		form.player2.parentNode.parentNode.childNodes[0] = '';
	}
	   
	if(form.mail1.value === '' || !checkEmailFormat(form.mail1.value)){
		returnval = false;
		form.mail1.parentNode.parentNode.setAttribute('class','control-group error');
		var s = form.mail1.parentNode.parentNode.childNodes[0];
		s.innerHTML = 'Player1 mail is missing';
	} else{
		form.mail1.parentNode.setAttribute('class','');
		form.mail1.parentNode.parentNode.childNodes[0]='';

	}
	
	if(form.mail2.value === '' || !checkEmailFormat(form.mail2.value)){
		returnval = false;
		form.mail2.parentNode.parentNode.setAttribute('class','control-group error');
		var s = form.mail2.parentNode.parentNode.childNodes[0];
		s.innerHTML = 'Player2 mail is missing';
	} else{
		form.mail2.parentNode.setAttribute('class','');
		form.mail2.parentNode.parentNode.childNodes[0]='';
	}
	   
	if(form.choice1.value === undefined || form.choice1.value === '' || form.choice1.value === null ){
		returnval = false;
		var el = document.getElementById('weapons');
		el.innerHTML = 'Your choice is missing!';
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