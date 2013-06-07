var arr = [1,2,3,4,5,6,7,8,9,10];

var async = function (data, callback) {
	var timeout = Math.ceil(Math.random() * 3000);
	setTimeout(function() {
		callback(null, data);
	}, timeout);
}

var insertAll = function(elements, callback) {
	var counter = elements.length;
	elements.forEach(function(elem) {
		console.log('calling '+elem);
		async(elem, function(err, data) {
			console.log('finished '+data);
			if (--counter == 0) {
				callback();
			}
		});
	});
}

insertAll(arr, function(err) {
	console.log('all finished');
});
