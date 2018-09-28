<?php /* Template Name: Homepage */ ?>
<?php get_header(); ?>

<main role="main">

	<?php get_template_part('/elements/hero'); ?>

	<?php if (is_home() && have_posts()) : while ( have_posts() ) : the_post(); ?>
		<?php the_title(); ?>
	<?php endwhile; endif; ?>

	<?php get_template_part('/elements/custom-blocks'); ?>

</main>

<?php get_footer(); ?>
