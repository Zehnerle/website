$(document).ready(function(){
	
	if(window.location.hash) {
	
		var link = window.location.hash.substring(1);
		var anchor = link.split("=");		
		
		$('.site').hide();
		
		if(anchor[0] == 'new')
			Navigation.newg();		
		else if(anchor[0] == 'results')	
			Navigation.results();		
		else if(anchor[0] == 'rules')
			Navigation.rules();		
		else if(anchor[0] == 'help')	
			Navigation.help();
		else if(anchor[0] == 'feedback')	
			Navigation.feedback();

		// EXTERNAL LINKS TO PLAYER2 AND GAME RESULT
		else if(anchor[0] == 'player2') {
			document.forms[1].choice2.value = '';
			Player2.externalLink();
		}
		else if(anchor[0] == 'result')
			Result.externalLink(); 	
			
		else Navigation.index();
	} 
	
	else Navigation.index();
	
});

var Navigation = {

	links:function(id) {
	
		$('.site').hide();
		Highscore.stop();
		
		if(!id.localeCompare('linkhome'))
			Navigation.index();
		else if(!id.localeCompare('linknew'))	
			Navigation.newg();
		else if(!id.localeCompare('linkresult'))
			Navigation.results();
		else if(!id.localeCompare('linkrules'))	
			Navigation.rules();
		else if(!id.localeCompare('linkhelp'))	
			Navigation.help();
		else if(!id.localeCompare('linkfeedback'))	
			Navigation.feedback();
	},
	
	index: function() {
		window.location.hash = 'start';
		Highscore.load();	
		$('#index').show();
	},
	
	newg: function() {
		window.location.hash = 'new';	
		Newgame.loadUserinfo();
		$('#newgame #weaponinfo').hide();
		$('#newgame').show();
	},	
	
	results: function() {
		window.location.hash = 'results';	
		Result.showResults();
	},
	
	rules: function() {
		window.location.hash = 'rules';	
		$('#ruless').show();
	},
	
	help: function() {
		window.location.hash = 'help';	
		$('#helps').show();
	},
	
	feedback: function() {
		window.location.hash = 'feedback';	
		$('#feedbacks').show();
	}

};
