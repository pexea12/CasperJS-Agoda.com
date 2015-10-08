var casper = require("casper").create({
    verbose: false,
    logLevel: 'error',
    pageSettings: {
        loadImages: false,
    }
});

casper.options.waitTimeout = 20000;

var utils = require('utils');
var x = require('casper').selectXPath;

var url = 'http://www.agoda.com/hotel-des-arts-saigon-mgallery-collection/hotel/ho-chi-minh-city-vn.html?checkin=' + casper.cli.get(0) + '&los=4&adults=2&childs=0&rooms=1';

var names = [];
var prices = [];
var currency = [];


function getName() {
    var rows = document.querySelectorAll('table#room-grid-table tbody tr td:first-child .info-container .room-name span');
    return Array.prototype.map.call(rows, function(e) {
        return e.innerHTML;
    });
}

function getPrice() {
    var price = document.querySelectorAll('table#room-grid-table tbody tr td:nth-child(3) .price span.sellprice');
    return Array.prototype.map.call(price, function(e) {
        return e.innerHTML;
    });
}

casper.selectOptionByValue = function(selector, valueToMatch){
    this.evaluate(function(selector, valueToMatch){
        var select = document.querySelector(selector),
            found = false;
        Array.prototype.forEach.call(select.children, function(opt, i){
            if (!found && opt.value.indexOf(valueToMatch) !== -1) {
                select.selectedIndex = i;
                found = true;
            }
        });
        var evt = document.createEvent("UIEvents"); 
        evt.initUIEvent("change", true, true);
        select.dispatchEvent(evt);
    }, selector, valueToMatch);
};


var currency = casper.cli.get(1);
casper.start(url, function() {
    this.selectOptionByValue('select[id="currency-options"]', currency);
});

casper.waitForSelector(x("//*[@id='room-grid-table']//*[@class='currency' and contains(text(), '"+currency+"')]"));

casper.then(function() {
    names = this.evaluate(getName);
    prices = this.evaluate(getPrice);
});

casper.then(function() {
    utils.dump(names);
    utils.dump(prices);
})

casper.run();