var Player2 = {

	internLink: function(hash) {
		window.location.hash = hash;
		Player2.externalLink();
	},

	externalLink: function() {
	
		var link = window.location.hash.substring(1);
		var anchor = link.split("=");		
		var path = getPath() + "/" + anchor[1];
			
		$.get(path + '/player2', function(data) {

			var obj = jQuery.parseJSON(data);			
			var content = '';		
			
			$('#player2 h3').html("Player2: " + obj.player2);
			if(obj.msg1 != '')
				$('#msghidden').html("Nachricht von Spieler1: '" + obj.msg1 +"'<br/><br/>").show();
		});
	
		$('.site').hide();
		$('#player2').show();
		
	},

	choice: function(id) {
		document.forms[1].choice2.value = id;
		weaponInfo(id, "#player2");
		$('#player2 #weapon_error').hide();
	},
	  
	submitCheck: function submitCheck() {

		var success = true;
		var form = document.forms[1];
		
		success &= Player2.checkValues(form);		
			
		if(success){
		
			var link = window.location.hash.substring(1);
			var anchor = link.split("=");
			var path = getPath() + "/" + anchor[1];
		
			$.ajax({
				url: path + '/player2Ajax',
				type: "POST",
				data: { 
					choice2: form.choice2.value,					
					msg2: form.msg2.value,
					mailcheckbox: form.mailcheckbox.value,
				},
				dataType: "json",
				success: function(success){ 
					Play.play();
					$('.site').hide();		
					$('#play').show();						
					$('#player2 form').each(function(){
					  this.reset();
					});				
					User.getUser();
					hideWeaponInfo('#player2');
				}
			});		
			
		}else{	//Scroll to the first form playe1
				$('html, body').animate({ scrollTop: $('#weapon_error').offset().top - 100}, 500);
		}	
		
		return false;
		
		
	},
	
	checkValues: function checkValues(form) {
	
		var success = true;
		
		$wp_field = $('#player2 #weapon_error');		  
		success &= weaponCheck(form.choice2.value, $wp_field);
			
		if(form.mailcheckbox['checked'])
			form.mailcheckbox.value = 'mail';
		else form.mailcheckbox.value = 'nomail';
		
		return success;
	}

};

