<?php 
get_header(); 
$homepage_id = get_option('page_on_front');
?>

<main role="main">
	<section class="hero">
	    <div class="slider" data-auto="true">
	        <div class="slides">
	            <div class="slide" style="background-image: url('<?php echo get_field('image', $homepage_id); ?>');"></div>
	            <?php if (have_rows('more_images', $homepage_id)): ?>
	                <?php while (have_rows('more_images', $homepage_id)): the_row(); ?>
	                    <div class="slide" style="background-image: url('<?php echo get_sub_field('image'); ?>');"></div>
	                <?php endwhile; ?>
	            <?php endif; ?>
	        </div>
	        <a href="#" class="slide-nav previous"><i class="icon-chevron-left"></i></a>
	        <a href="#" class="slide-nav next"><i class="icon-chevron-right"></i></a>
	    </div>
	    <div class="content-wrapper">
	    	<a href="/" title="Camping de l'Eau rouge" class="logo-holder">
	            <img class="logo small" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" title="Domaine de l'eau rouge" alt="Domaine de l'eau rouge" />
	        </a>
	        <h1 class="<?php echo get_field('title_color', $homepage_id); ?>"><?php _e('Oeps', 'eaurouge' ); ?></h1>
	        <h2 class="<?php echo get_field('subtitle_color', $homepage_id); ?>"><?php _e('Pagina niet gevonden', 'eaurouge' ); ?></h2>
	    </div>
	</section>
	<?php get_template_part('/elements/breadcrumbs'); ?>
	<div class="content-wrapper">
		<div class="section-intro intro-only">
			<h2 class="red">
				<span class="sub blue"><?php _e('Oeps', 'eaurouge' ); ?></span>
				<?php _e('Pagina niet gevonden', 'eaurouge' ); ?>
			</h2>
			<a class="button red" href="/" title="Home">Home <i class="icon icon-chevron-right"></i></a>
			<a class="button blue" href="/boeken" title="<?php _e('Direct reserveren', 'eaurouge'); ?>"><?php _e('Direct reserveren', 'eaurouge'); ?> <i class="icon icon-chevron-right"></i></a>
		</div>
	</div>
</main>

<?php get_footer(); ?>
