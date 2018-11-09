/*
 *  Module: carousel
 */

require('./vendor/jquery.owl.carousel');
var $ = require('jquery');
var $carousel = $('.js-owlCarousel');

/**
 * Initialize carousels
 */
function init() {
	$carousel.owlCarousel({
		items: 1,
		itemsCustom: [
			[0, 1]
		],
		rewindNav: true,
		navigation: true,
		navigationText: ['<', '>'], // use icon font to display arrows
		pagination: true,
		autoplay: true,
		stopOnHover: true,
		responsiveBaseWidth: window //for IE8 set to main wrapper
	});
};

/**
 * Destroy carousel
 * @param  {string} selector The selector of the carousel to destroy
 * @return {boolean}         True if carousel destroyed
 */
function destroy(selector) {
	if ( $carousel.length ) {
		$carousel.data('owlCarousel').destroy();
		return true;
	}
	return false;
}

/**
 * Public API
 * @type {Object}
 */
module.exports = {
	init: init,
	destroy: destroy
};