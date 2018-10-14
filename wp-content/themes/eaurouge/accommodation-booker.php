<?php /* Template Name: Book-accommodation-page */ ?>

<?php get_header(); ?>

	<main role="main">
		<?php get_template_part('/elements/hero'); ?>
		<section class="section" id="accommodation-booker">
			<div class="content-wrapper">
				<div class="column-holder">
                    <div class="column main">
						<div class="content-wrapper no-top">
							<div class="box turqoise">
								<div class="content-wrapper">
									<?php
									global $post;
									$post = get_post($_GET['accommodation_id']);
									setup_postdata( $post );
									get_template_part('/elements/accommodation-finder/accommodation-preview-simple');
									wp_reset_postdata();
									?>
								</div>
							</div>
							<h2 class="blue">Jouw gegevens</h2>
                        </div>
                    </div>
					<div class="column aside">
						<div class="box green">
							<div class="content-wrapper">
								<h3 class="yellow"><span class="white sub">Overzicht van</span> jouw verblijf</h3>
								<?php
									$adults = intval($_GET['adults']);
									$children = intval($_GET['children']);
									$pets = intval($_GET['pets']);

									$hasDates  = isset($_GET['date_from']) && isset($_GET['date_to']);

									if ($hasDates) {
										$date_from = date_create_from_format('d-m-Y', $_GET['date_from']);
										$date_from_comparable = date_format($date_from,'Ymd');
										$date_to = date_create_from_format('d-m-Y', $_GET['date_to']);
										$date_to_comparable = date_format($date_to,'Ymd');
										$nights = $date_to->diff($date_from)->format("%a");
									}

									$price = 0;
									$pricePeriods = get_field('price_periods', $_GET['accommodation_id']);


									if ($pricePeriods) {
										$currentPricePeriod = array_filter($pricePeriods, function ($period) use ($date_from_comparable) {
											return $date_from_comparable >= $period['period_from'] && $date_from_comparable <= $period['period_to'];
										});

										$currentPricePeriod = reset($currentPricePeriod);
									}
								?>
								<?php if($pricePeriods && $currentPricePeriod): ?>
								<ul class="price-detail white">
									<?php $total = 0; ?>
									<li>
										<?php
										$price = $nights * floatval($currentPricePeriod['price_per_night']);
										$total += $price;
										?>
										<span><?php echo $nights; ?> x nacht(en)</span>
										<strong>€ <?php echo number_format($price, 2); ?></strong>
									</li>
									<li>
										<?php
										$price = $nights * $adults * floatval($currentPricePeriod['price_per_adult']);
										$total += $price;
										?>
										<span><?php echo $adults; ?> x volwassen(en)</span>
										<strong>€ <?php echo number_format($price, 2); ?></strong>
									</li>
									<li>
										<?php
										$price = $nights * $children * floatval($currentPricePeriod['price_per_child']);
										$total += $price;
										?>
										<span><?php echo $children; ?> x kind(eren)</span>
										<strong>€ <?php echo number_format($price, 2); ?></strong>
									</li>
									<li>
										<?php
										$price = $nights * $pets * floatval($currentPricePeriod['price_per_dog']);
										$total += $price;
										?>
										<span><?php echo $pets; ?> x huisdier(en)</span>
										<strong>€ <?php echo number_format($price, 2); ?></strong>
									</li>
									<li>
										<?php
										$price = $nights * floatval($currentPricePeriod['electricty_per_night']);
										$total += $price;
										?>
										<span><?php echo $nights; ?> x elektra</span>
										<strong>€ <?php echo number_format($price, 2); ?></strong>
									</li>
									<li>
										<?php
										$price = $nights * ($adults + $children) * floatval($currentPricePeriod['tourist_tax_per_night']);
										$total += $price;
										?>
										<span><?php echo ($adults + $children); ?> x toeristenbelasting</span>
										<strong>€ <?php echo number_format($price, 2); ?></strong>
									</li>
									<li>
										<?php
										$price = floatval($currentPricePeriod['booking_costs_per_stay']);
										$total += $price;
										?>
										<span>1 x reserveringskosten</span>
										<strong>€ <?php echo number_format($price, 2); ?></strong>
									</li>
									<li class="total">
										<span>Totaal:</span>
										<strong>€ <?php echo number_format($total, 2); ?></strong>
									</li>
								</ul>
								<?php endif; ?>
							</div>
						</div>
					</div>
		        </div>
			</div>
		</section>
	</main>

<?php get_footer(); ?>
