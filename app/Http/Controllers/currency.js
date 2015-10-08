var casper = require("casper").create({
    verbose: false,
    logLevel: 'error',
    pageSettings: {
        loadImages: false,
    }
});

var utils = require('utils');

var url = 'http://www.agoda.com/hotel-des-arts-saigon-mgallery-collection/hotel/ho-chi-minh-city-vn.html?checkin=2015-11-14&los=4&adults=2&childs=0&rooms=1';

var currency = [];

function getCurrency() {
	var currency = document.querySelectorAll('select#currency-options option');
	return Array.prototype.map.call(currency, function(e) {
		return e.innerHTML;
	});
}

casper.start(url, function() {
    currency = this.evaluate(getCurrency);
});


casper.then(function() {
    utils.dump(currency);
})

casper.run();