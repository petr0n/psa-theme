/*
 *  Module: social
 */

require('jquery-colorbox');
var $    = require('jquery');
var util = require('./util.js');

var defaults = {
	channelAttrName: "share-channel",
	fbAppId: '',
	mandrillApi: ''
};

/**
 * Constructor
 * @param {Object} options Optional properties to override defaults
 */
function SocialShare(options) {
	this.options = $.extend({}, defaults, options);
}

/**
 * Open lightbox with email share form
 */
function openEmailShare(el) {
	var self = this;

	// open lightbox with form
	$.colorbox({
		href: urls.ajax,
		data: {
			action: 'get_form_email'
		},
		onComplete: function() {
			var $form = $('.form--email').find('form');

			// on form submit create object of values from form
			$form.on('submit', function(e) {
				e.preventDefault();

				// TODO: perform validation first

				var opts = {};
				var fields = $form.serializeArray();

				$.each(fields, function(i, field) {
					opts[field.name] = field.value;
				});

				opts.htmlBody = opts.textBody;

				if ( el ) {
					opts.subject = $(el).data('subject');
				}

				self.mandrillShare(opts).done(function (data) {
					if ( data.status === 'error' ) {
						console.log('Mandrill error: ', data.message);
					} else {
						$.colorbox.close();
					}
				});
			});
		}
	});
}

/**
 * Setup
 */
SocialShare.prototype.init = function () {
	var self = this;
	// Grab all the elements with valid channel data attributes
	$('[data-' + self.options.channelAttrName + ']').each(function() {
		// on click trigger the appropriate share function
		$(this).on('click', function () {
			var data = $(this).data();
			var channel = data[ util.camelCase(self.options.channelAttrName) ];

			if ( channel === 'mandrill' ) {
				openEmailShare.call(self, this);
				return;
			}

			var url = self[channel + 'Share'](data);
			// if url is a string open popup
			var popup = (url) ? window.open(url, 'share', 'resizable=yes,scrollbars=yes,width=600,height=500') : false;
			return false;
		});
	});
}

/**
 * Loads FBSDK if needed and pops a share dialogue
 * @return {false} Returns false to disable default link behavior on click
 */
SocialShare.prototype.facebookShare = function (details) {
	var options = this.options;

	function loadFbSdk(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {
			return;
		}
		js = d.createElement(s);
		js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	};

	// check for fb sdk, if not present add to page
	if (!window.fbAsyncInit) {
		$('body').append('<div id="fb-root"></div>');

		// Asynchronously load fb jssdk
		loadFbSdk(document, 'script', 'facebook-jssdk');

		// Initialize Facebook app
		window.fbAsyncInit = function() {
			FB.init({
				appId: options.fbAppId, // App ID from the App Dashboard
				status: false, // check the login status upon init?
				cookie: true, // set sessions cookies to allow your server to access the session?
				xfbml: true, // parse XFBML tags on this page?
				version: 'v2.1'
			});
			openDialog();
		};
	} else {
		openDialog();
	}

	// Open Facebook share dialog w/provided data
	function openDialog() {
		FB.ui({
			method: 'feed',
			name: details.title,
			link: details.url,
			picture: details.image,
			caption: details.caption,
			description: details.description
		});
	}

	return false;
}

/**
 * Builds Twitter share url
 * @return {String}
 */
SocialShare.prototype.twitterShare = function (details) {
	var url = details.url || document.location.href;
	var text = details.text.substring(0, 140) || "";
	var hashtags = details.hashtags || "";
	var via = details.via || "";
	return 'http://twitter.com/share?url=' + encodeURI(url) + '&text=' + text + '&hashtags=' + hashtags + '&via=' + via;
}

/**
 * Builds Pinterest share url
 * @return {String}
 */
SocialShare.prototype.pinterestShare = function (details) {
	var url = details.url || document.location.href;
	var media = encodeURI(details.media) || "";
	var description = details.description | "";
	return 'http://www.pinterest.com/pin/create/button/?url=' + encodeURI(url) + '&media=' + media + '&description=' + description;;
}

/**
 * Builds LinkedIn share url
 * @return {String}
 */
SocialShare.prototype.linkedinShare = function (details) {
	var url = details.url || document.location.href;
	var title = details.title || "";
	var summary = details.summary || "";
	var source = details.source || "";
	return 'https://www.linkedin.com/shareArticle?mini=true&url=' + encodeURI(url) + '&title=' + title + '&summary=' + summary + '&source=' + source;
}

/**
 * Builds Google+ share url
 * @return {String}
 */
SocialShare.prototype.googleplusShare = function (details) {
	var url = details.url || document.location.href;
	return 'https://plus.google.com/share?url=' + encodeURI(url);
}

/**
 * Handles email share via Mandrill
 * @return {String}
 */
SocialShare.prototype.mandrillShare = function (data) {
	var self = this;
	var defaults = {
		fromEmail: 'no-reply@' + window.location.hostname,
		fromName: '',
		toEmail: '',
		toName: '',
		subject: 'Read this article from: ' + urls.base,
		htmlBody: '',
		textBody: ''
	}
	var details = $.extend({}, defaults, data);

	return $.ajax({
		type: 'POST',
		url: 'https://mandrillapp.com/api/1.0/messages/send.json',
		data: {
			'key': self.options.mandrillApi,
			'message': {
				'auto_text': true,
				'auto_html': true,
				'inline_css': true,
				'headers': {
					'Reply-to': details.fromEmail
				},
				'from_email': details.fromEmail,
				'from_name': details.fromName,
				'to': [{
					'email': details.toEmail,
					'name': details.toName,
					'type': 'to'
				}],
				'subject': details.subject,
				'html': window.location.href + '\n\n' + details.htmlBody,
				'text': window.location.href + '\n\n' + details.textBody
			}
		}
	});
}

/**
 * Public API
 * @type {Object}
 */
module.exports = SocialShare;