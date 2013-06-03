$(document).ready(function(){
	User.getUser();	  
});

var User = {

	getUser: function getUser() {
	
		var path = getPath();
		
		$.get(path + '/user', function(data) {
			var obj = jQuery.parseJSON(data);	
			
			if(obj.user != null)
				$('#user').html("Spieler: '" + obj.user + "'");
		});

	}

};
