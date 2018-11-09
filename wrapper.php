<?php get_template_part('partials/head'); ?>
<body <?php body_class(); ?>>
	<?php
		do_action('get_header');
		get_template_part('partials/header');
	?>

	<main class="main">
		<?php psa_get_template(); ?>
	</main>

	<?php
		do_action('get_footer');
		get_template_part('partials/footer');
	?>
</body>
</html>