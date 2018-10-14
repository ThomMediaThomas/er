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
							</form>
							<?php get_template_part('/elements/accommodation-booker/your-details'); ?>
                        </div>
                    </div>
					<div class="column aside">
						<?php get_template_part('/elements/accommodation-booker/price-detail'); ?>
						<div class="box red">
							<div class="content-wrapper">
								<h4 class="white">Let op!</h4>
								<p class="white">Jouw reservering is pas definitief als je een bevesting per e-mail ontvangen hebt.</p>
								<p class="yellow">Wij proberen binnen 24 uur na ontvangst een bevestiging te sturen.</p>
							</div>
						</div>
					</div>
		        </div>
			</div>
		</section>
	</main>

<?php get_footer(); ?>
