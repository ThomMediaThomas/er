<?php /* Template Name: Book-accommodation-page */ ?>

<?php get_header(); ?>
	<main role="main">
		<?php get_template_part('/elements/hero'); ?>
		<section class="section" id="accommodation-booker">
			<div class="content-wrapper">
				<div class="column-holder stick-in-parent-parent">
                    <div class="column main">
						<div class="content-wrapper">
                            <?php the_field('page_intro'); ?>
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
						<div class="stick-in-parent">
							<?php get_template_part('/elements/accommodation-booker/price-detail'); ?>
							<a class="button red" href="javascript:$('form.frm-show-form').submit()">
								<?php _e('Verzenden', 'eaurouge'); ?> 
								<i class="icon-chevron-right"></i>
							</a>							
						</div>
					</div>
		        </div>
			</div>
		</section>
	</main>

<?php get_footer(); ?>
