<?php

/**
 * Front End CSS
 */
function psa_load_styles() {
	if ( WP_DEBUG ) {
		wp_enqueue_style('main-style', get_bloginfo('template_url') . '/dist/styles/app.css', array(), false, 'screen');
	} else {
		wp_enqueue_style('main-style', get_bloginfo('template_url') . '/dist/styles/app.min.css', array(), false, 'screen');
	}
}
add_action('wp_enqueue_scripts', 'psa_load_styles');

/**
 * Front End JS
 */
function psa_load_scripts() {
	wp_deregister_script('jquery');

	// Theme Script
	if ( WP_DEBUG ) {
		wp_enqueue_script('main', get_bloginfo('template_url').'/dist/scripts/app.js', array(), false, true);
	} else {
		wp_enqueue_script('main', get_bloginfo('template_url').'/dist/scripts/app.min.js', array(), false, true);
	}

	// WordPress Scripts
	if( is_singular() && get_option('thread_comments') ) wp_enqueue_script('comment-reply');

	// Dynamic URLs for use in scripts
	wp_localize_script( 'main', 'urls', array(
		'base' => get_bloginfo('url'),
		'theme' => get_bloginfo('template_url'),
		'ajax' => admin_url('admin-ajax.php')
	));

	// Initialize vars for JS
	wp_localize_script( 'main', 'info', array( /* IDs, etc. */ ));
}
add_action('wp_enqueue_scripts', 'psa_load_scripts');

/**
 * Admin CSS
 */
function psa_load_admin_styles() {
	wp_enqueue_style( 'admin', get_bloginfo('template_url') . '/dist/styles/admin.css' );
}
//add_action('admin_enqueue_scripts', 'psa_load_admin_styles');

/**
 * Admin JS
 */
function psa_load_admin_scripts() {
	wp_enqueue_script( 'admin', get_bloginfo('template_url') . '/dist/scripts/admin.js' );
}
//add_action('admin_enqueue_scripts', 'psa_load_admin_scripts');

/**
 * Login CSS
 */
function psa_load_login_styles() {
	echo '<link rel="stylesheet" href="' . get_bloginfo('template_url') . '/dist/styles/admin.css" type="text/css" />';
}
//add_action('login_head', 'psa_load_login_styles');