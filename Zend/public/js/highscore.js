
$(document).ready(function(){
		refreshTable();	  
});
	
function refreshTable() {

	$.ajax({
		url: 'http://' + document.location.hostname + '/Zend/game/highscore',
		datatype: 'json',
		success: function(data) {	
		
			var obj = jQuery.parseJSON(data);
			
			var content = '';
			
			$.each(obj.highscore, function(key, value) {				
				content += "<tr><td>" + value._id + "</td><td>" + value.num + "x</td></tr>";				
			});					
			
			$('#highscore tbody').html(content);					
			
		},
	});
	
	setTimeout(refreshTable, 10000);
	
};
