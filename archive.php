<div class="container">
	<div class="row">
		<section class="col-sm-8">
			<?php if ( have_posts() ) : the_post(); ?>
				<h1 class="page-title archive">
					<?php if ( is_tag() ) : ?>
						<?php single_tag_title(); ?>
					<?php elseif ( is_day() ) : ?>
						Daily Archives: <?php the_time('F jS, Y'); ?>
					<?php elseif ( is_month() ) : ?>
						Monthly Archives: <?php the_time('F, Y'); ?>
					<?php elseif ( is_year() ) : ?>
						Yearly Archives: <?php the_time('Y'); ?>
					<?php else : ?>
						<?php single_cat_title(); ?>
					<?php endif; ?>
				</h1>
			<?php endif; rewind_posts(); ?>

			<ul>
				<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<li class="post" id="<?php the_ID(); ?>">
						<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="formatted">
							<?php echo get_the_excerpt(); ?> <a href="<?php the_permalink(); ?>">Read more</a>
						</div>
					</li>
				<?php endwhile; else : ?>
					<li class="post">
						<h2>Page Not Found</h2>
						<p>No posts were found that match your criteria.</p>
					</li>
				<?php endif; ?>
			</ul>

			<div class="post-nav">
				<div class="prev"><?php next_posts_link('&laquo; Older Entries') ?></div>
				<div class="next"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			</div>
		</section>

		<?php psa_get_sidebar(); ?>
	</div>
</div>