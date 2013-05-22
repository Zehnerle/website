
/* Danke Gruppe 2! */


function reply_click(id) {
	var x = document.forms[0].choice2;
	x.value = id;
}
  
function submitCheck() {

	var returnval = true;
	var form = document.forms[0];
	
	if(form.mail2.value === '') {
		returnval = false;
		mail2 = form.mail2.parentNode.parentNode;
		mail2.setAttribute('class','control-group error');
		mail2.childNodes[0].innerHTML = 'Mail is missing';
	} else {
		mail2 = form.mail2.parentNode;
		mail2.setAttribute('class','');
		mail2.parentNode.childNodes[0]= '';
	}
	   
	if(form.choice2.value === undefined || form.choice2.value === '' || form.choice2.value === null ){
		returnval = false;
		var el = document.getElementById('weapons');
		el.innerHTML = 'Your choice is missing!';
	}
	
	return returnval;
}
