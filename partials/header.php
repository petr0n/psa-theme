<header class="header">
	<div class="header-container container">
		<?php if( is_front_page() ) : ?>
			<h1 class="header-logo">
				<a class="header-logo" href="<?php echo bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a>
			</h1>
		<?php else : ?>
			<a class="header-logo" href="<?php echo bloginfo('url'); ?>"><?php echo bloginfo('name'); ?></a>
		<?php endif; ?>

		<div class="header-menu mainMenu">
			<div class="mainMenu-titleBar">
				<button class="mainMenu-toggle">&times;</button>
			</div>
			<div class="searchForm searchForm--mainMenu">
				<?php psa_get_template_part('partials', 'searchform'); ?>
			</div>

			<?php wp_nav_menu( array(
				'theme_location' => 'header',
				'container' => 'nav',
				'container_class' => 'mainMenu-menu',
				'menu' => 'Header',
				'menu_class' => 'mainMenu-list'
			)); ?>
		</div>
	</div>
</header>