/*
 *  Main entry point
 */

require('es5-shim');
require('consolelog');

var $               = require('jquery');
var carousel        = require('./carousel.js');
// var responsive      = require('./responsive.js');
// var SocialModule    = require('./social.js');
// var AnalyticsModule = require('./analytics.js');
// var social = new SocialModule({ fbAppId: '' });
// var analytics = new AnalyticsModule({ gaid: '' });

/**
 * Initialize the app on DOM ready
 */
$(function() {
	carousel.init();
	// analytics.init();
	// social.init();
	// responsive.init();
});