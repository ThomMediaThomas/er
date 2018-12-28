<?php /* Template Name: Page */ ?>

<?php get_header(); ?>

	<main role="main">

		<?php get_template_part('/elements/hero'); ?>
		<?php if (!empty(get_the_content())): ?>
			<div class="content-wrapper">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>
		<?php get_template_part('/elements/custom-blocks'); ?>

	</main>

<?php get_footer(); ?>
