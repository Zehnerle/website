var arr = [1,2,3,4,5,6,7,8,9,10];

var async = function (data, callback) {
	var timeout = Math.ceil(Math.random() * 300);
	setTimeout(function() {
		callback(null, data);
	}, timeout);
}

var insertAll = function(elements, callback) {
	var queue = elements.slice(0);
	
	(function iterate() {
		if (queue.length == 0) {
			callback();
			return;
		}

		var elem = queue.splice(0,1)[0];
		async(elem, function(err, data) {
			if (err) { throw err; }
			console.log('finished '+data);
			process.nextTick(iterate);
		});
	})();

}

insertAll(arr, function(err) {
	console.log('all finished');
});
