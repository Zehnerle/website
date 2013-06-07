var net = require('net'),
    carrier = require('carrier');

var connections = [];
 
net.createServer(function(conn) {
	connections.push(conn);

	conn.on('close',function() {
		var pos = connections.indexOf(conn);
		if (pos > -1) {
			connections.splice(pos,1);
		}
	});

	var username = "user"+connections.length;

	conn.write('Hi, welcome to your DBIS-Chat-Server\n');
	conn.write("I don't know your name, so I call you "+username+"\n");

	carrier.carry(conn, function(line) {
		var msg;
		if (line == 'quit') {
			conn.end();
			msg = username+" left chat, byebye";
		} else {
			msg = username+": "+line;
		}
		connections.forEach(function(c) {
			if (c !== conn) {
				c.write(msg+"\n");
			}
		});
	});

}).listen(5000);
