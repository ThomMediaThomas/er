<?php get_header(); ?>

<main role="main">

	<section class="hero" style="background-image: url('<?php echo get_field('image', get_option('page_for_posts')); ?>');">
		<div class="content-wrapper">
			<?php if (get_field('show_logo', get_option('page_for_posts'))) : ?>
				<a href="/" title="Camping de l'eau rouge" class="logo-holder">
					<img class="logo small" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" title="Domaine de l'eau rouge" alt="Domaine de l'eau rouge" />
				</a>
			<?php endif; ?>
			<h1 class="<?php echo get_field('title_color', get_option('page_for_posts')); ?>"><?php echo get_field('title', get_option('page_for_posts')); ?></h1>
			<h2 class="<?php echo get_field('subtitle_color', get_option('page_for_posts')); ?>"><?php echo get_field('subtitle', get_option('page_for_posts')); ?></h2>
		</div>
	</section>

	<?php
		$counter = 0;
		if (is_home() && have_posts()) : while ( have_posts() ) : the_post();
	?>
		<section class="section">
			<?php if($counter%2 == 0): ?>
				<div class="block image turqoise" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>')">
					<?php echo the_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
			<div class="block text">
				<div class="content-wrapper">
					<h3 class="red"><span class="sub"><?php the_time('d-m-Y') ?> | Domaine de l' Eau Rouge:</span> <?php the_title(); ?></h3>
					<p><?php echo get_the_excerpt(); ?></p>
					<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" class="button red">Lees verder <i class="icon-chevron-right"></i></a>
				</div>
			</div>
			<?php if($counter%2 != 0): ?>
				<div class="block image turqoise" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>')">
					<?php echo the_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
		</section>
	<?php
		$counter++;
		endwhile;
		endif;
	?>

</main>

<?php get_footer(); ?>
