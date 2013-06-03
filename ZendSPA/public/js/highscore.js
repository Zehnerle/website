var t;

var Highscore = {	

	load: function refreshTable(){
	
		var path = 'http://' + document.location.hostname 
			+ '/' + location.pathname.split('/')[1] + '/game';				
			
		$.get(path + '/indexAjax', function(data) {

				var obj = jQuery.parseJSON(data);			
				var content = '';
				
				$.each(obj.highscore, function(key, value) {				
					content += "<tr><td>" 
					+ value._id + "</td><td>" 
					+ value.num + "x</td></tr>";				
				});					
				
				$('#highscore tbody').html(content);
		});
		
		t = setTimeout(refreshTable, 30000);	
		
	}, 
	
	stop: function() {
		clearTimeout(t);
	}

};


