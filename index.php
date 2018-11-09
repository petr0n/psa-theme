<div class="container">
	<div class="row">
		<?php get_template_part('partials/carousel'); ?>
	</div>
	<div class="row">
		<section class="postFeed col-sm-8">
			<ol class="postFeed-postList">
				<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>

					<li class="postFeed-post formatted" id="post-<?php the_ID(); ?>">
						<h2 class="postFeed-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="postFeed-byline">Posted by <?php the_author_posts_link(); ?> on <?php the_time('F j, Y'); ?> in <?php the_category(', '); ?> | <?php comments_number(); ?></p>
						<?php the_excerpt(); ?>
					</li>

				<?php endwhile; else : ?>

					<li class="postFeed-post">
						<h2 class="postFeed-title">Posts Not Found</h2>
						<p class="postFeed-byline">No posts were found that match your criteria.</p>
					</li>

				<?php endif; ?>
			</ol>

			<div class="postFeed-pagination">
				<div class="postFeed-prev"><?php next_posts_link('&laquo; Older Entries') ?></div>
				<div class="postFeed-next"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			</div>
		</section>

		<?php psa_get_sidebar(); ?>
	</div>
</div>