
	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			&copy; <?php echo date('Y'); ?> [company name here]. All rights reserved.
			<span class="sep"> | </span>
			<a href="https://zava.design" target="_blank">Website by Zava Design</a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<nav id="mmenu" class="mm-menu">
	<?php
	wp_nav_menu( array(
		'container'       => '',
		'items_wrap'	=> '<ul>%3$s</ul>'
	) );
	?>
</nav>

<?php wp_footer(); ?>

</body>
</html>
