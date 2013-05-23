/* Danke Gruppe 2! */
function reply_click(id) {
	var x = document.forms[0].choice2;
	x.value = id;
}
  
function submitCheck() {

	var returnval = true;
	var form = document.forms[0];
	
	//Check E-Mail 2
	if(form.mail2.value === '') {
		returnval = false;
		on('player2mail_error');
	} else {
		if(!checkEmailFormat(form.mail2.value)) {
			returnval = false;
			on('player2mail2_error');
		} else {
			off('player2mail2_error');
		}
		off('player2mail_error');
	}
	
	//Check Weapons  
	if(form.choice2.value === undefined || form.choice2.value === '' || form.choice2.value === null ) {
		returnval = false;
		on('weapon_error');
	}else{
		off('weapon_error');
	}
	
	return returnval;
}

//Display element with id ON
function on(id) {
	document.getElementById(id).style.display = 'block';
}

//Display element with id OFF
function off(id) {
	document.getElementById(id).style.display = 'none';
}

//Check if Emailformat is valid
function checkEmailFormat(email) {
	var strReg = "^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$";
	var regex = new RegExp(strReg);
	  return(regex.test(email)); 
}
