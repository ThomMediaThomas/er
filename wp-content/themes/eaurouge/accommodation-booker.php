<?php /* Template Name: Book-accommodation-page */ ?>

<?php
	$adults = intval($_GET['adults']);
	$children = intval($_GET['children']);
	$babies = intval($_GET['babies']);
	$pets = intval($_GET['pets']);

	$hasDates  = !empty($_GET['date_from']) && !empty($_GET['date_to']);

	if ($hasDates) {
	    $date_from = date_create_from_format('d-m-Y', $_GET['date_from']);
	    $date_from_comparable = date_format($date_from,'Ymd');
	    $date_to = date_create_from_format('d-m-Y', $_GET['date_to']);
	    $date_to_comparable = date_format($date_to,'Ymd');

	    if ($date_from && $date_to) {
	        $nights = $date_to->diff($date_from)->format("%a");
	    } else {
	        $nights = 0;
	    }
	}

	$price = 0;
	$pricePeriods = get_field('price_periods', $_GET['accommodation_id']);


	if ($pricePeriods) {
	    //GET BUNDLES
	    $bundles;

	    $meta_query = array(
	        'key'       => 'for_accommodations',
	        'value'     => $_GET['accommodation_id'],
	        'compare'   => 'LIKE',
	    );

	    $bundles = new WP_query(); 
	    $bundles->query(array(
	        'post_type' => array('bundle'),
	        'meta_query' => array($meta_query)
	    )); 

	    $current_bundles = array_filter($bundles->posts, function ($bundle) use ($date_from_comparable, $date_to_comparable) {
	        return 
	            ($date_from_comparable >= $bundle->start_bundle && $date_from_comparable <= $bundle->end_bundle) ||
	            ($date_to_comparable >= $bundle->start_bundle && $date_to_comparable <= $bundle->end_bundle);
	    });

	    $current_bundle = reset($current_bundles);

	    if ($current_bundle) {
	        if ($nights < $current_bundle->min_nights) {
	            $nights = $current_bundle->min_nights;
	        }
	    }
	    //END GET BUNDLES

	    $currentPricePeriods = array_filter($pricePeriods, function ($period) use ($date_from_comparable, $date_to_comparable) {
	        return 
	            ($date_from_comparable >= $period['period_from'] && $date_from_comparable <= $period['period_to']) ||
	            ($date_to_comparable >= $period['period_from'] && $date_to_comparable <= $period['period_to']);
	    });

	    $currentPricePeriod = null;

	    foreach ($currentPricePeriods as $period) {
	        if (!isset($currentPricePeriod['priority'])) {
	            $currentPricePeriod = $period;
	        }

	        if (
	            $period['priority'] > $currentPricePeriod['priority']
	        ) {
	            $currentPricePeriod = $period;
	        }
	    }

	    $pricePerNight = $currentPricePeriod['price_per_night'];

	    if ($currentPricePeriod['has_bundle_discount']) {
	        foreach($currentPricePeriod['bundles'] as $bundle) {
	            if ($bundle['amount_nights'] <= $nights) {
	                $pricePerNight = $bundle['bundle_price_per_night'];
	            }
	        }
	    }

	    $disabled_extras_for_period = null;
	    if ($currentPricePeriod && $currentPricePeriod["disabled_extras_for_period"]) {
	        $disabled_extras_for_period = $currentPricePeriod["disabled_extras_for_period"];
	    }


	    $isAvailable = (isset($currentPricePeriod['available']) && $currentPricePeriod['available']) || !isset($currentPricePeriod['available']);

	    $askForFamilyMembers = isset($currentPricePeriod["ask_for_family_members"]) ? $currentPricePeriod["ask_for_family_members"] : false;
	}
?>
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
								<div id="ask-for-family-members-box">
									<?php if($askForFamilyMembers): ?>
										<?php get_template_part('/elements/accommodation-booker/selected-family-members'); ?>
									<?php endif; ?>
								</div>
								<hr />
								<?php get_template_part('/elements/accommodation-booker/selected-extras'); ?>
								<hr />
							</form>
							<?php if($isAvailable): ?>
								<?php get_template_part('/elements/accommodation-booker/your-details'); ?>
							<?php else: ?>
								<div class="box red">
					                <div class="content-wrapper narrow">
										<p class="white"><?php _e('Deze accommodatie is helaas niet beschikbaar in de gekozen periode.', 'eaurouge'); ?></p>
									</div>
								</div>
							<?php endif; ?>
                        </div>
                    </div>
					<div class="column aside">
						<div class="stick-in-parent">
							<div class="box green" id="box-price-detail">
							    <div class="content-wrapper">
							        <?php the_field('price_intro'); ?>
							        <?php if($isAvailable && $pricePeriods && $currentPricePeriod ): ?>                
							            <div class="box yellow booking-summary">
							                <div class="content-wrapper narrow">
							                    <h4 class="red"><?php echo get_the_title($_GET['accommodation_id']); ?></h3>
							                    <?php if(!empty($_GET['date_from']) && !empty($_GET['date_to'])): ?>
							                        <ul>
							                            <li><strong><?php _e('Van', 'eaurouge'); ?>:</strong> <?php echo $_GET['date_from']; ?></li>
							                            <li><strong><?php _e('Tot', 'eaurouge'); ?>:</strong> <?php echo $_GET['date_to']; ?></li>
							                        </ul>
							                    <?php endif; ?>  
							                </div>
							            </div>
							            <?php if ($currentPricePeriod['notes_for_period']): ?>
							                <p class="yellow smaller"><?php echo $currentPricePeriod['notes_for_period']; ?></p>
							            <?php endif; ?> 
							            <ul class="price-detail white">
							                <?php $total = 0; ?>
							                <li>
							                    <?php
							                    $price = $nights * floatval($pricePerNight);
							                    $total += $price;

							                    $price = $nights * $adults * floatval($currentPricePeriod['price_per_adult']);
							                    $total += $price;

							                    $price = $nights * $children * floatval($currentPricePeriod['price_per_child']);
							                    $total += $price;

							                    $price = $nights * $babies * floatval($currentPricePeriod['price_per_baby']);
							                    $total += $price;

							                    $price = $nights * $pets * floatval($currentPricePeriod['price_per_dog']);
							                    $total += $price;
							                    ?>
							                    <span><?php echo $nights; ?> x <?php _e('nachten', 'eaurouge'); ?></span>
							                    <strong>€ <?php echo number_format($total, 2); ?></strong>
							                    <?php if(!empty($_GET['adults']) || !empty($_GET['children']) || !empty($_GET['babies']) || !empty($_GET['pets'])): ?>
							                        <ul>
							                            <?php if (!empty(($_GET['adults']))) : ?>
							                                <li><?php echo $_GET['adults']; ?> <?php _e('Volwassenen', 'eaurouge'); ?></li>
							                            <?php endif; ?>
							                            <?php if (!empty(($_GET['children']))) : ?>    
							                                <li><?php echo $_GET['children']; ?> <?php _e('Kinderen (4 t/m 15 jaar)', 'eaurouge'); ?></li>
							                            <?php endif; ?>
							                            <?php if (!empty(($_GET['babies']))) : ?>
							                                <li><?php echo $_GET['babies']; ?> <?php _e('Kinderen (0 t/m 3 jaar)', 'eaurouge'); ?></li>
							                            <?php endif; ?>
							                            <?php if (!empty(($_GET['pets']))) : ?>
							                                <li><?php echo $_GET['pets']; ?> <?php _e('Huisdieren', 'eaurouge'); ?></li>
							                            <?php endif; ?>
							                        </ul> 
							                <?php endif; ?> 
							                </li>
							                <?php
							                $extras = get_field('extras', $_GET['accommodation_id']);
							                $selected_extras = $_GET['extras'];
							                $extra_counter = 0;

							                if ($selected_extras):
							                    foreach ($selected_extras as $extra_key):
							                        if (($disabled_extras_for_period && !in_array($extra_key, $disabled_extras_for_period)) || !$disabled_extras_for_period) :
							                            $extra_counter++;
							                            $extra = array_filter($extras, function ($extra) use ($extra_key){
							                                return $extra['key'] == $extra_key;
							                            });

							                            if ($extra) :
							                                $extra = reset($extra);
							                                ?>
							                                <li <?php if($extra_counter == 1): ?>class="with-separator"<?php endif; ?>>
							                                    <?php
							                                    $amount = $extra['price_is_per_night'] ? $nights : 1;
							                                    $price = $amount * floatval($extra['price']);
							                                    $total += $price;
							                                    ?>
							                                    <span><?php echo $amount; ?> x <?php _e(strtolower($extra['title']), 'eaurouge'); ?></span>
							                                    <strong>€ <?php echo number_format($price, 2); ?></strong>
							                                </li>
							                            <?php endif;
							                        endif;
							                    endforeach;
							                endif; ?>
							                <li class="with-separator">
							                    <?php
							                    $price = $nights * ($adults + $children + $babies) * floatval($currentPricePeriod['tourist_tax_per_night']);
							                    $total += $price;
							                    ?>
							                    <span><?php _e('milieu-heffing (pppn.)', 'eaurouge'); ?></span>
							                    <strong>€ <?php echo number_format($price, 2); ?></strong>
							                </li>
							                <li class="">
							                    <?php
							                    $price = floatval($currentPricePeriod['booking_costs_per_stay']);
							                    $total += $price;
							                    ?>
							                    <span>1 x <?php _e('reserveringskosten', 'eaurouge'); ?></span>
							                    <strong>€ <?php echo number_format($price, 2); ?></strong>
							                </li>
							                <?php if ($currentPricePeriod['has_discount']): ?>
							                    <?php 
							                        $discount = 0; 

							                        if ($currentPricePeriod['discount_type'] == 'percentage') {
							                            $discount = ($total/100) * $currentPricePeriod['discount'];
							                        } else {
							                            $discount = $currentPricePeriod['discount'];
							                        }
							                    ?>
							                    <li class="total">
							                        <span><?php _e('Totaal', 'eaurouge'); ?>:</span>
							                        <strong>
							                            <span id="original-price">€ <?php echo number_format($total, 2); ?></span>
							                            <span id="total-price">€ <?php echo number_format($total - $discount, 2); ?></span>
							                        </strong>
							                    </li>
							                    <li class="discount">
							                        <span><?php _e('Korting', 'eaurouge'); ?>:</span>
							                        <strong id="total-price">€ <?php echo number_format($discount, 2); ?><br /></strong>
							                    </li>
							                <?php else: ?>
							                    <li class="total">
							                        <span><?php _e('Totaal', 'eaurouge'); ?>:</span>
							                        <strong id="total-price">€ <?php echo number_format($total, 2); ?><br /></strong>
							                    </li>
							                <?php endif; ?>
							                <?php if(get_field('caution', $_GET['accommodation_id'])): ?>
							                    <li class="caution">
							                        <span><?php _e('Waarborg', 'eaurouge'); ?>:</span>
							                        <strong>€ <?php echo number_format(get_field('caution', $_GET['accommodation_id']), 2); ?><br /></strong>
							                    </li>
							                <?php endif; ?>
							                <li class="info">
							                    <?php the_field('note_below_price'); ?>
							                </li>
							            </ul>
							        <?php endif; ?>
							    </div>
							</div>

						</div>
					</div>
		        </div>
			</div>
		</section>
	</main>

<?php get_footer(); ?>
