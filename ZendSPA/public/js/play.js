var revancheData = '';

var Play = {
		
	play: function getResult() {
		
		var path = getPath();
			
		$.get(path + '/playAjax', function(data) {
			
			var obj = jQuery.parseJSON(data);	
			var content = '';	
			
			if(obj.output == 'Du hast verloren!') {
				revancheData = obj.game;
				obj.output += " <a href='" + path + "#new' onClick='Newgame.revanche();'>Revanche starten?</a>";
			}
							
			$('#result').html(obj.output);
			
			choice1 = obj.enum[obj.game.choice1-1];
			choice2 = obj.enum[obj.game.choice2-1];
			
			if(obj.game.winner === 'TIE')
				obj.game.winner = 'Unentschieden';
			
			content = "<tr><td>" + obj.game.player1 + "</td><td>" 
				+ obj.game.player2 + "</td><td>"
				+ choice1 + "</td><td>"
				+ choice2 + "</td><td>"
				+ obj.game.winner + "</td></tr>";
				
			$('#play tbody').html(content);
			$('#play').show();
		});
		
	}

}
