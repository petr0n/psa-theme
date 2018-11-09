<?php

/**
 * Post Type Declaration
 */
$labels = array(
	'name' => 'Slides',
	'singular_name' => 'Slide',
	'add_new' => 'Add New',
	'add_new_item' => 'Add New Slide',
	'edit_item' => 'Edit Slide',
	'new_item' => 'New Slide',
	'view_item' => 'View Slide',
	'search_items' => 'Search Slides',
	'not_found' => 'No Slides Found',
	'not_found_in_trash' => 'No Slides Found in Trash',
	'menu_name' => 'Slides'
);

$args = array(
	'labels' => $labels,
	'description' => '',
	'public' => true,
	'exclude_from_search' => false,
	'publicly_queryable' => true,
	'show_ui' => true,
	'show_in_nav_menus' => false,
	'show_in_menu' => true,
	'show_in_admin_bar' => true,
	'menu_position' => 10,
	'menu_icon' => 'dashicons-images-alt2', // http://melchoyce.github.io/dashicons/
	'capability_type' => 'post',
	'hierarchical' => true,
	'supports' => array( 'title', 'editor', 'thumbnail' ),
	//'register_meta_box_cb' => 'init_slide_fields',
	'taxonomies' => array(),
	'has_archive' => true
);

register_post_type( 'slide', $args );

/**
 * Custom Form Fields
 */
function init_slide_fields() {
	add_meta_box( "destination", "Destination", "slide_destination", "slide", "normal", "high" );
}

function slide_destination() {
	global $post;
	$custom = get_post_custom( $post->ID );
	$destination = $custom['destination'][0];
	wp_nonce_field("metaNonce", 'metaNonce'); ?>

	<input type="text" name="destination" value="<?php echo $destination; ?>" /> <?php
}

function save_slide_fields() {
	global $post;
	if ( wp_verify_nonce( $_POST['metaNonce'], 'metaNonce' ) ) {
		if( array_key_exists('destination', $_POST) ) update_post_meta( $post->ID, 'destination', $_POST['destination'] );
	}
}

add_action("save_post", "save_slide_fields");

/**
 * Custom Title Placeholder
 */
function slide_change_title_placeholder( $title ){
     $screen = get_current_screen();
     if ( $screen->post_type == 'slide' ) {
          $title = 'Enter slide title here';
     }
     return $title;
}
add_filter('enter_title_here', 'slide_change_title_placeholder');