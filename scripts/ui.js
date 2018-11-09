/**
 * Module: ui
 * Helper functions for manipulating the DOM
 */

require('jquery-colorbox');
var $ = require('jquery');

/**
 * Scrolls the window to the desired offset
 * @param  {Mixed} A number of pixels from the top of a page, or a string containing a dom selector
 */
function scrollTo(destination) {
	var $viewport = $('html, body');

	if (typeof destination === 'number') { // If provided a numerical offset, scroll there
		$viewport.animate({ scrollTop: destination }, 500, 'swing');
		return false;
	}

	if (destination === 'top') { // if dest is top, go to top of window
		$viewport.animate({ scrollTop: 0 }, 500, 'swing');
		return false;
	}

	if ( $(destination).length ) { // if dest matches a dom element, scroll to it
		var offset = $(destination).offset();
		$viewport.animate({ scrollTop: offset.top }, 500, 'swing');
		return false;
	}
};

/**
 * Set the height of each element in the args to be equal to the tallest element in that collection
 * @param  {Object} cols An object of the items to be equalized
 * @return {Number}      Height of the tallest element
 */
function equalHeights(cols) {
	var largest = 0;
	var $cols = cols;

	// remove heights that may already be set
	$cols.height('auto');

	$cols.each(function() {
		var height = $(this).height();
		if (height > largest) {
			largest = height;
		}
	});

	$cols.height(largest);

	return largest;
};

/**
 * Opens a lightbox for the item that is passed in
 */
function openLightbox() {
	$(this).colorbox({
		iframe: true,
		innerWidth: '80%',
		innerHeight: '80%',
		previous: '<',
		next: '>',
		close: 'x'
	});
}

/**
 * Public API
 * @type {Object}
 */
module.exports = {
	equalHeights: equalHeights,
	scrollTo: scrollTo,
	openLightbox: openLightbox
};