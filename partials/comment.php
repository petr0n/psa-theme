<?php global $comment, $args, $depth;
// note the closing li is removed from the template
// as it is automatically inserted by wp
// http://codex.wordpress.org/Function_Reference/wp_list_comments
?>

<li id="<?php comment_id(); ?>" <?php comment_class(); ?>>
	<cite>
		On <?php comment_date('M. j, Y'); ?> at <?php comment_time(); ?>, <?php comment_author_link(); ?> said: <?php edit_comment_link('Edit'); ?>
		<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</cite>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<p><em>Your comment is awaiting moderation.</em></p>
	<?php endif; ?>
	<div class="entry"><?php comment_text(); ?></div>