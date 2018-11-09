<?php
$tmp_search = new WP_Query('s=' . esc_html($_GET['s']) . '&show_posts=-1&posts_per_page=-1');
$count = $tmp_search->post_count;
?>

<div class="container">
	<section class="postFeed postFeed--search row" >
		<div class="col-sm-12">
			<h1 class="postFeed-feedTitle">
				<?php echo $count; ?> Result<?php if($count != 1) { echo 's'; } ?> for "<?php echo esc_html($_GET['s']); ?>"
			</h1>
			<ul class="postFeed-postList">
				<?php if(have_posts()) : while(have_posts()) : the_post();
					$keys = explode( " ", $s );
					$title 	= preg_replace( '/('.implode('|', $keys) .')/iu', '<strong class="highlight">\0</strong>', get_the_title() );
					$excerpt = preg_replace( '/('.implode('|', $keys) .')/iu', '<strong class="highlight">\0</strong>', get_the_excerpt() );
				?>

					<li class="postFeed-post" id="<?php the_ID(); ?>">
						<h2 class="postFeed-title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h2>
						<div class="userFormatted">
							<?php echo $excerpt; ?> <a href="<?php the_permalink(); ?>">Read more</a>
						</div>
					</li>

				<?php endwhile; else : ?>

					<li class="postFeed-post">
						<h2>Posts Not Found</h2>
						<p>No posts were found that match your criteria.</p>
					</li>

				<?php endif; ?>
			</ul>

			<div class="postFeed-pagination">
				<div class="postFeed-prev"><?php next_posts_link('&laquo; Older Entries') ?></div>
				<div class="postFeed-next"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			</div>
		</div>
	</section>
</div>