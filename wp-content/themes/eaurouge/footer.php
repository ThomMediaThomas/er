		<?php get_template_part('/elements/site-footer'); ?>
		<?php wp_footer(); ?>
		<?php $scriptVersion = 5; ?>
		<script src="<?php echo get_template_directory_uri(); ?>/scripts/vendor/jquery.2.2.4.min.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/scripts/vendor/datepicker.1.0.0.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/scripts/vendor/datepicker.nl-NL.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/scripts/vendor/date.format.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/scripts/helpers.js?v=<?php echo $scriptVersion; ?>"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/scripts/main.js?v=<?php echo $scriptVersion; ?>"></script>
	</body>
</html>
