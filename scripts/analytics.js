/*
 *  Module: Analytics
 */

var $ = require('jquery');

var defaults = {
	attrName: "track-event",
	gaid: "UA-NNNNNN-N",
	addGA: true
};

/**
 * Constructor
 * @param {Object} options Optional properties to override defaults
 */
function Analytics(options) {
	this.options = $.extend({}, defaults, options);
}

/**
 * Adds GA script to DOM and triggers pageview event
 */
Analytics.prototype.addGA = function(i, s, o, g, r, a, m) {
	var self = this,
		i = i || window,
		s = s || document,
		o = o || 'script',
		g = g || '//www.google-analytics.com/analytics.js',
		r = r || 'ga';

	i['GoogleAnalyticsObject'] = r;
	i[r] = i[r] || function() {
		(i[r].q = i[r].q || []).push(arguments)
	}, i[r].l = 1 * new Date();
	a = s.createElement(o),
	m = s.getElementsByTagName(o)[0];
	a.async = 1;
	a.src = g;
	m.parentNode.insertBefore(a, m);

	/**
	 * Set up GA account and log pageview
	 */
	i.ga('create', self.options.gaid);
	i.ga('send', 'pageview');
};

/**
 * Takes a DOM node and uses one of it's data-attributes to gather tracking data
 * @param  {object} el DOM node to parse
 * @return {object}    Object containing the necessary GA tracking data
 */
Analytics.prototype.parseElementData = function(el) {
	// grab data attributes from element
	var self = this;
	var $el = $(el);
	var data = $el.data(self.options.attrName);
	var trackingData = {};

	trackingData.url = ( $el.attr("href") ) ? $el.attr("href") : null;

	// If the data attribute isn't present exit
	if (!data) {
		return false;
	}

	// Turn the data string into an array
	dataArray = data.split(",");

	// Trim whitespace from data
	$.each(dataArray, function(i) {
		dataArray[i] = this.trim(dataArray[i]);
	});

	// return object with category, action, label, and value
	trackingData = {
		'category': dataArray[0],
		'action': dataArray[1],
		'label': dataArray[2],
		'value': dataArray[3]
	}

	return trackingData;
};

/**
 * Triggers a GA custom event based on the triggering element's data
 * @param  {Object} el The element that triggered the event
 */
Analytics.prototype.trackEvent = function(data) {
	if ( !data || !window.ga ) {
		return;
	}

	// Send data to GA: category, action, label (if link then href else another value), value (number)
	window.ga('send', 'event', data.category, (data.action || 'click'), data.label, (data.value || 1));

	// If active link, delay so we can capture event then follow it
	// http://support.google.com/analytics/bin/answer.py?hl=en&answer=1136920
	if (data.url) {
		setTimeout(function() {
			return true;
		}, 100);
	}
};

/**
 * Init
 */
Analytics.prototype.init = function () {
	var self = this;
	var scrolled = false;
	var scrolledToBottom = false;

	// add GA script if not yet in DOM
	if (self.options.addGA === true && !window.ga) {
		self.addGA();
	}

	// apply event tracking to all elements with appropriate data-attribute
	$('[data-' + self.options.attrName + ']').each(function () {
		$(this).on('click', function() {
			var trackingData = self.parseElementData(this);
			self.trackEvent(trackingData);
		});
	});

	// track scrolling events
	$(window).on('scroll', function () {
		if (!scrolled) {
			ga("send", "event", "scroll", "user scrolled window", window.location.href);
			scrolled = true;
		}

		if ( ($(window).scrollTop() + $(window).height()) === $(document).height() ) {
			if (!scrolledToBottom) {
				ga("send", "event", "scroll", "user scrolled to end of page", window.location.href);
				scrolledToBottom = true;
			}
		}
	});
};

/**
 * Public API
 */
module.exports = Analytics;