<?php if ( post_password_required() ) : ?>
	<p class="nopassword">This post is password protected. Enter the password to view any comments.</p>
<?php return; endif; ?>

<?php if ( have_comments() ) : ?>
	<h2>Comments</h2>
	<ul class="comments-list">
		<?php wp_list_comments( array('callback' => 'psa_comment_list') ); ?>
	</ul>
<?php endif;?>


<?php if ( comments_open() ) : ?>
	<div id="respond" class="comments-respond">
		<h2><?php comment_form_title( 'Leave a Comment', 'Leave a Reply to %s' ); ?></h2>
		<p class="align-center"><?php cancel_comment_reply_link(); ?></p>

		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
			<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
		<?php else : ?>
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comment-form" class="comment-form">
				<ul>
					<?php if ( $user_ID ) : ?>
						<li>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></li>
					<?php else : ?>

					<li>
						<label for="author">Name:</label>
						<input type="text" name="author" id="author" class="medium" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
					</li>
					<li>
						<label for="email">E-Mail: <small>(not displayed)</small></label>
						<input type="text" name="email" id="email" class="medium" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
					</li>
					<li>
						<label for="url">URL:</label>
						<input type="text" name="url" id="url" class="medium" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
					</li>

					<?php endif; ?>

					<li>
						<label for="comment">Comments:</label>
						<textarea name="comment" id="comment" class="medium" tabindex="4"></textarea>
					</li>
					<li>
						<input class="btn-submit" name="submit" type="submit" id="submit" tabindex="5" value="Leave Comment" />
						<?php comment_id_fields(); ?>
					</li>
				</ul>
				<?php do_action('comment_form', $post->ID ); ?>
			</form>
		<?php endif; ?>
	</div> <!-- end #respond -->
<?php else : ?>
	<p class="nocomments">Comments are closed.</p>
<?php endif; ?>
