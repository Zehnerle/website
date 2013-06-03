var Newgame = {	

	loadUserinfo: function loadUserinfo() {
	
		var form = document.forms[0];
		var path = getPath();
			
		$.get(path + '/new', function(data) {

			var obj = jQuery.parseJSON(data);	
			if(obj != '') {
				form.player1.value = obj.player1;
				form.mail1.value = obj.mail1;
			}
			if(obj.mail2 && obj.player2) {
				form.player2.value = obj.player2;
				form.mail2.value = obj.mail2;
			}
			
		});
	
	},
	
	revanche: function revanche() {
		hideWeaponInfo();
		var form = document.forms[0];
		form.choice1.value = '';
		form.player1.value = revancheData.player2;
		form.player2.value = revancheData.player1;
		form.mail1.value = revancheData.mail2;
		form.mail2.value = revancheData.mail1;
		$('.site').hide();
		$('#newgame').show();		
	},
			
	choice: function(id) {
		document.forms[0].choice1.value = id;
		weaponInfo(id, "#newgame");
		$('#newgame #weapon_error').hide();
	},
	
	submitCheck: function submitCheck() {

		var success = true;
		var form = document.forms[0];	
		var path = getPath();		
		
		success &= Newgame.checkValues(form);
			
		if(success){
		
			$.ajax({
				url: path + '/newAjax',
				type: "POST",
				data: { 
					choice1: form.choice1.value,
					mail1: form.mail1.value,
					mail2: form.mail2.value,
					player1: form.player1.value,
					player2: form.player2.value,
					msg1: form.msg1.value,
					mailcheckbox: form.mailcheckbox.value,
				},
				dataType: "json",
				success: function(success){ 
					$('#newgame form').each(function(){
					  this.reset();
					});
					$('.site').hide();					
					Highscore.load();
					$('#index').show();
					User.getUser();
					hideWeaponInfo();
				}
			});		
			
		}	
		
		return false;
	},
	
	checkValues: function checkValues(form) {
	
		var success = true;
		
		$p1_field = $('#newgame #player1_error');
		$m1_field = $('#newgame #player1mail_error');
		$p2_field = $('#newgame #player2_error');
		$m2_field = $('#newgame #player2mail_error');
		$wp_field = $('#newgame #weapon_error');
		
		//Check Player Infos
		success &= playerCheck(form.player1.value, $p1_field);		
		success &= mailCheck(form.mail1.value, $m1_field);
		success &= playerCheck(form.player2.value, $p2_field);
		success &= mailCheck(form.mail2.value, $m2_field);

		//Check Weapons  
		success &= weaponCheck(form.choice1.value, $wp_field);
			
		if(form.mailcheckbox['checked'])
			form.mailcheckbox.value = 'mail';
		else form.mailcheckbox.value = 'nomail';
		
		return success;
	}

};	  