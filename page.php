<?php the_post(); ?>

<div class="container">
	<section class="article row">
		<article class="userFormatted col-sm-8">
			<h1 class="userFormatted-title"><?php the_title(); ?></h1>
			<?php the_content(); ?>
		</article>
		<?php psa_get_sidebar(); ?>
	</section>
</div>