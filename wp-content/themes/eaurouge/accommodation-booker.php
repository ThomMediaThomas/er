<?php /* Template Name: Book-accommodation-page */ ?>

<?php get_header(); ?>
	<main role="main">
		<?php get_template_part('/elements/hero'); ?>
		<section class="section" id="accommodation-booker">
			<div class="content-wrapper">
				<div class="column-holder">
                    <div class="column main">
						<div class="content-wrapper no-top">
							<?php global $wp; ?>
							<form id="booking-details-form" action="<?php echo home_url($wp->request); ?>" method="GET">
								<?php get_template_part('/elements/accommodation-booker/selected-accommodation'); ?>
								<hr />
								<?php get_template_part('/elements/accommodation-booker/selected-period'); ?>
								<hr />
								<?php get_template_part('/elements/accommodation-booker/selected-family'); ?>
								<hr />
								<?php get_template_part('/elements/accommodation-booker/selected-extras'); ?>
								<hr />
							</form>
							<?php get_template_part('/elements/accommodation-booker/your-details'); ?>
                        </div>
                    </div>
					<div class="column aside">
						<?php get_template_part('/elements/accommodation-booker/price-detail'); ?>
					</div>
		        </div>
			</div>
		</section>
	</main>

<?php get_footer(); ?>
