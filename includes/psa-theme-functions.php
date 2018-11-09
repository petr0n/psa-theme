<?php

/**
 * AJAX Function Template
 */
function function_name() {
	extract( $_POST, EXTR_SKIP );

	$array = array();

	echo json_encode( $array );
	exit;
}
add_action( 'wp_ajax_nopriv_function_name', 'function_name' );
add_action( 'wp_ajax_function_name', 'function_name' );

/**
 * Returns template for email share
 */
function get_form_email() {
	global $post;
	echo psa_get_template_part( 'partials/form', 'email' );
	exit;
}
add_action('wp_ajax_nopriv_get_form_email', 'get_form_email');
add_action('wp_ajax_get_form_email', 'get_form_email');