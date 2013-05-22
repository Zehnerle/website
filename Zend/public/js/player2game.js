
/* von Gruppe 2 ausgeliehen */

function reply_click(id) {
	var x = document.forms[0].choice2;
	x.value = id;
}
  
function submitCheck() {

	var returnval = true;
	var form = document.forms[0];

	if(form.mail2.value === ''){
		returnval = false;
		form.mail2.parentNode.parentNode.setAttribute('class','control-group error');
		var s = form.mail2.parentNode.parentNode.childNodes[0];
		s.innerHTML = 'Mail is missing';
	} else{
		form.mail2.parentNode.setAttribute('class','');
		form.mail2.parentNode.parentNode.childNodes[0]='';
	}
	   
	if(form.choice2.value === undefined || form.choice2.value === '' || form.choice2.value === null ){
		returnval = false;
		var el = document.getElementById('weapons');
		el.innerHTML = 'Your choice is missing!';
	}
	
	return returnval;
}
