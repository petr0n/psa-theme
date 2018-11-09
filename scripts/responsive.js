/*
 *  Module: Responsive
 *  Fire callbacks on breakpoint change
 */

var enquire = require('./vendor/enquire');

/**
 * Monitors window size for breakpoints
 */
function monitorBreakpoints() {
	enquire.
		register("screen and (max-width: 767px)", { // X-Small
			match: function() {
				console.log('<= 767px');
			},
			unmatch: function() {}
		}).
		register("screen and (min-width: 768px)", { // Small
			match: function() {
				console.log('>= 768px');
			},
			unmatch: function() {}
		}).
		register("screen and (min-width: 992px)", { // Medium
			match: function() {
				console.log('>= 992px');
			},
			unmatch: function() {}
		}).
		register("screen and (min-width: 1170px)", { // Large
			match: function() {
				console.log('>= 1170px');
			},
			unmatch: function() {}
		});
};

/**
 * Public API
 */
module.exports = {
	init: monitorBreakpoints
};