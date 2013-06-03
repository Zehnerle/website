var Result = {

	externalLink: function() {
	
		var link = window.location.hash.substring(1);
		var anchor = link.split("=");	
		var path = getPath() + "/" + anchor[1];		
			
		$.get(path + '/result', function(data) {
			
			var obj = jQuery.parseJSON(data);				
			Result.printActualGame(obj);
			var revanche = '';
			
			if((obj.actualgame.player1 != obj.actualgame.winner) &&
				(obj.actualgame.winner != 'Unentschieden')) {
				revancheData = obj.actualgame;
				revanche = " <a href='" + getPath() + "#new' onClick='Newgame.externalRevanche();'>Revanche starten?</a>";
			}
			
			$('#actualgameh3').append(revanche);
			
		});
	
		$('.site').hide();
		$('#actualgame').show();
		
	},
		
	showResults: function showResults() {
		
		var path = getPath();
			
		$.get(path + '/resultAjax', function(data) {
				
			var obj = jQuery.parseJSON(data);			
			var content = '';
			
			if(!obj.opengames && !obj.closedgames) {				
				$('div #guest').html("Hier kannst Du Deine offenen und abgeschlossenen Spiele einsehen, nachdem Du ein neues Spiel erstellt hast oder eine Herausforderung zu einem Spiel angenommen hast!").show();
				$('#results').hide();

			}				
			else {
				Result.printOpenGames(obj, path);
				Result.printClosedGames(obj);				
				$('#results').show();
			}
				
		});
		
	},
	
	printActualGame: function printActualGame(obj) {

		var content = '';
		var choice1, choice2;

		if(!obj.actualgame  || obj.actualgame == '') {
			$('#actualgame').hide();
			return;
		}
			
		var value = obj.actualgame;	
		choice1 = obj.enum[value.choice1-1];
		choice2 = obj.enum[value.choice2-1];	
		
		if(value.winner == 'TIE') 
			value.winner = 'Unentschieden';				
				
		content += "<tr><td>" + value.player1 + "</td><td>" 
		+ value.player2 + "</td><td>"
		+ choice1 + "</td><td>"
		+ choice2 + "</td><td>"
		+ value.winner + "</td></tr>";	
			
		$('#actualgame tbody').html(content);

	},

	printOpenGames: function printOpenGames(obj, path) {

		var content = '';
	
		if(!obj.opengames || obj.opengames == '') {
			$('#opengames').hide();
			return;
		}
		
		$.each(obj.opengames, function(key, value) {		
			content += "<tr><td>" + value.player1 + "</td><td>" 
			+ value.player2 + "</td>";	
			if(obj.user && (obj.user == value.player2)) {				
				content += "<td><a href='" + path + "#player2=" + value.hash + "' onClick='Player2.internLink(this.href);'>Play</a></td>";						
			} else 
				content += "<td></td>";
				
			content += "</tr>";
			
			});					
			
		$('#opengames tbody').html(content);
		$('#opengames').show();

	},

	printClosedGames: function printClosedGames(obj) {
	
		var content = '';
		var choice1, choice2;
		
		if(!obj.closedgames || obj.closedgames == '') {
			$('#closedgames').hide();
			return;
		}
		
		$.each(obj.closedgames, function(key, value) {			
			choice1 = obj.enum[value.choice1-1];
			choice2 = obj.enum[value.choice2-1];	
			
			if(value.winner == 'TIE') 
				value.winner = 'Unentschieden';				
			
			content += "<tr><td>" + value.player1 + "</td><td>" 
			+ value.player2 + "</td><td>"
			+ choice1 + "</td><td>"
			+ choice2 + "</td><td>"
			+ value.winner + "</td></tr>";			
		});					
			
		$('#closedgames tbody').html(content);
		$('#closedgames').show();

	}
		
};


	

