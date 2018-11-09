<!DOCTYPE html>
<!--[if lte IE 8 ]> <html <?php language_attributes(); ?> class="ie ie8 lte9 lte8 no-js"> <![endif]-->
<!--[if IE 9 ]>     <html <?php language_attributes(); ?> class="ie ie9 lte9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title('|'); ?></title>
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="cleartype" content="on">

	<?php wp_head(); ?>

	<!--[if lte IE 9 ]>
		<script src="<?php bloginfo('template_url') ?>/scripts/vendor/respond.js"></script>
		<script src="<?php bloginfo('template_url') ?>/scripts/vendor/mediamatch.js"></script>
	<![endif]-->
</head>
