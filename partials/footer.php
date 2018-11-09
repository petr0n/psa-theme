<footer class="footer">
	<div class="footer-container container">
		<address class="footer-copyright">&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?></address>
		<?php wp_nav_menu( array(
			'theme_location' => 'footer',
			'container' => 'nav',
			'container_class' => 'footer-menu menuBar menuBar--text',
			'menu' => 'Footer',
			'menu_class' => 'footer-menuList menuBar-list'
		)); ?>
	</div>

	<?php wp_footer(); ?>
</footer>