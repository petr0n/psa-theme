<?php

/**
 * Loads template part file
 *
 * @param string $slug The slug name for the generic template or sub-directory
 * @param string $name The name of the specialised template
 * @param bool $echo Echo output immediately or buffered and returned
 * @param array $param Array of additional params to include in scope
 */
function psa_get_template_part( $slug, $name, $echo = true, $params = array() ) {
	global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

	do_action( "get_template_part_{$slug}", $slug, $name );

	$templates = array();
	if ( isset( $name ) ) {
		$templates[] = "{$slug}/{$name}.php";
		$templates[] = "{$slug}-{$name}.php";
	}
	$templates[] = "{$slug}.php";

	$template_file = locate_template( $templates, false, false );

	// Add query vars and params to scope
	if ( is_array( $wp_query->query_vars ) ) {
		extract( $wp_query->query_vars, EXTR_SKIP );
	}
	extract( $params, EXTR_SKIP );

	// Buffer output and return if echo is false
	if( !$echo ) ob_start();
	require( $template_file );
	if( !$echo ) return ob_get_clean();
}

/**
 * Loads comment template
 *
 * @param object $comment The comment object
 * @param array $args Comment arguments
 * @param int $depth The depth of the current comment
 */
function psa_comment_list( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$GLOBALS['args'] = $args;
	$GLOBALS['depth'] = $depth;
	get_template_part('partials/comment');
}

/**
 * Truncates a string to the nearest word under a given maximum length
 *
 * @param string $string The string which will be truncated
 * @param int $length The length to which to truncate the string
 * @param string $append A string that will be appended to the end of a truncated string
 */
function psa_truncate( $string, $length, $append = '&hellip;' ) {
	if( strlen( $string ) > $length ) {
		$string = substr( $string, 0, strrpos( substr( $string, 0, $length ), ' ') );
		$string .= $append;
	}
	return $string;
}

/**
 * Retrieves the url of the post thumbnail
 *
 * @param (string) $size The size of the thumbnail to be retrieved
 * @return (string) The post thumbnail url
 */
function psa_get_the_post_thumbnail_src( $size = 'thumbnail' ) {
	global $post;
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size );
	return $image[0];
}

/**
 * Get all of the images attached to the current post
 * Excludes the post thumbnail
 *
 * @param string $size Desired image size
 * @return array
 */
function psa_get_post_images_src( $size = 'thumbnail' ) {
	global $post;
	
	$images = get_children( array('exclude' => get_post_thumbnail_id( $post->ID ), 'post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order') );
		
	$results = array();

	if ( $images ) {
		foreach ( $images as $image ) {
			// get the correct image html for the selected size
			$results[] = wp_get_attachment_image_src( $image->ID, $size );
		}
	}
	
	return $results;
}

/**
 * Parses a string for a YouTube video ID
 *
 * @param string $string Valid YouTube video URL or ID
 * @return string YouTube video ID
 */
function psa_get_youtube_video_id( $string ) {
	if( !parse_url( $string, PHP_URL_HOST ) ) return $string;
	if ( strpos( $string, 'youtu.be/') === false && strpos( $string, '/embed/') === false ) {
		parse_str( parse_url( $string, PHP_URL_QUERY ), $query );
		$id = $query['v'];
	} else {
		$id = basename( parse_url( $string, PHP_URL_PATH ) );
	}

	return $id;
}

/**
 * Generates a YouTube iFrame embed
 * Duplicates wp_oembed_get() but this allows specifying of YouTube video arguments
 *
 * @param string $id Valid YouTube video ID
 * @param array $iframe_args List of arguments for the iframe markup
 * @param array $youtube_args List of arguments for the youtube video
 * @return string HTML for iFrame embed
 */
function psa_youtube_embed( $id, $iframe_args = array(), $youtube_args = array() ) {
	$iframe_defaults = array(
		'class' => 'video',
		'width' => 640,
		'height' => 360,
		'responsive' => false
	);
	$iframe_args = wp_parse_args( $iframe_args, $iframe_defaults );
	extract( $iframe_args, EXTR_SKIP );

	$youtube_defaults = array(
		'autoplay' => 1,
		'rel' => 0,
		'origin' => get_bloginfo('url')
	);
	$youtube_args = wp_parse_args( $youtube_args, $youtube_defaults );
	$youtube_args = http_build_query( $youtube_args );

	$dimensions = ( $responsive ) ? '' : 'width="' . $width . '" height="' . $height . '"';

	// iFrame embed
	printf('<iframe type="text/html" class="%s" %s src="https://www.youtube.com/embed/%s?%s" frameborder="0"></iframe>', $class, $dimensions, $id, $youtube_args );
}

/**
 * Accepts a YouTube video ID and returns a shortened link
 *
 * @param int $id Valid YouTube video ID
 * @return string Short YouTube video link
 */
function psa_youtube_link( $id, $embeded = false ) {
	if ( $embeded == true ) {
		return 'https://www.youtube.com/embed/' . $id . '?rel=0&autoplay=1';
	} else {
		return 'https://youtu.be/' . $id;
	}
}

/**
 * Creates a compressed zip archive from an array of files
 *
 * @param (array) $files Array of file locations ( on disk not HTTP )
 * @param (string) $destination Location and file name for the zip to be created
 * @param (bool) $overwrite Whether or not to overwrite the destination if it already exists
 * @param (bool) $preserve_folder_structure Whether or not to preserve the folder structure or grab only the files
 * @return (bool) Whether or not the destination file exists
 */
function psa_create_zip( $files = array(), $destination = '', $overwrite = false, $preserve_folder_structure = false ) {
	// if the zip file already exists and overwrite is false, return false
	if( file_exists( $destination ) && !$overwrite ) { return false; }

	// vars
	$valid_files = array();

	// if files were passed in...
	if( is_array( $files ) ) {
		// cycle through each file
		foreach( $files as $file ) {
			// make sure the file exists
			if( file_exists( $file ) ) {
				$valid_files[] = $file;
			}
		}
	}
	// if we have good files...
	if( count( $valid_files ) ) {
		// create the archive
		$zip = new ZipArchive();
		if( $zip->open( $destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE ) !== true ) {
			return false;
		}

		// add the files
		foreach( $valid_files as $file ) {
			$localname = ( $preserve_folder_structure ) ? $file : basename( $file );
			$zip->addFile( $file, $localname );
		}

		// close the zip -- done!
		$zip->close();

		// check to make sure the file exists
		return file_exists( $destination );
	} else {
		return false;
	}
}

/**
 * Debug tool - displays contents of any variable wrapped in pre tags
 *
 * @param $variable Variable you want to debug
 */
function psa_debug( $variable ) {
	echo "<pre>";
	if( is_array( $variable ) || is_object( $variable ) ) {
		print_r( $variable );
	} else {
		var_dump( $variable );
	}
	echo "</pre>";
}

/**
 * Converts a string into Twitter share friendly format
 *
 * @param  string $string String to format
 * @return string         Twitter sharable string
 */
function psa_format_twitter_text($string) {
	return htmlspecialchars(urlencode(html_entity_decode($string, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
}