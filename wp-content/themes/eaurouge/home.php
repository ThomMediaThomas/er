<?php /* Template Name: Homepage */ ?>
<?php get_header(); ?>
	<main role="main">
		<section class="hero" style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/uitzicht-weiland.jpg');">
			<div class="content-wrapper">
				<a href="/" title="Camping de l'eau rouge">
					<img class="logo" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" title="Domaine de l'eau rouge" alt="Domaine de l'eau rouge" />
				</a>
			</div>
		</section>
		<?php get_template_part('/elements/custom-blocks'); ?>
	</main>

<?php get_footer(); ?>
