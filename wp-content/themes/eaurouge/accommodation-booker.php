<?php /* Template Name: Book-accommodation-page */ ?>

<?php get_header(); ?>

	<main role="main">
		<?php get_template_part('/elements/hero'); ?>
		<section class="section" id="accommodation-booker">
			<div class="content-wrapper">
				<div class="column-holder">
                    <div class="column main">
						<div class="content-wrapper no-top">
							<h2 class="blue">Jouw gekozen verblijf</h2>
							<p>In de vorige stap koos je voor het volgende verblijf, wil je toch nog je verblijf wijzigen? Dat kan, ga dan terug naar <a href="javascript:history.back()" title="Ga terug naar de vorige stap">de vorige stap</a>.</p>
							<div class="box turqoise">
								<input type="hidden" id="accommodation_id" name="accommodation_id" value="<?php echo $_GET['accommodation_id']; ?>"/>
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
							<hr />
							<h2 class="blue">Periode</h2>
							<p>Wil je de gekozen periode wijzigen? Dat kan, ga dan terug naar <a href="javascript:history.back()" title="Ga terug naar de vorige stap">de vorige stap</a>.</p>
							<div class="period">
								<div class="input-field">
									<?php $stayDateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : null; ?>
									<label for="stay_date_from">Van:</label>
									<span class="input-with-icon">
										<i class="date"></i>
										<input disabled="disabled" name="date_from" value="<?php echo $stayDateFrom; ?>" class="datepicker" id="date_from" type="text" placeholder="dd-mm-jjjj">
									</span>
								</div>
								<div class="input-field">
									<?php $stayDateTo = isset($_GET['date_to']) ? $_GET['date_to'] : null; ?>
									<label for="stay_date_to">Tot:</label>
									<span class="input-with-icon">
										<i class="date"></i>
										<input disabled="disabled" name="date_to" value="<?php echo $stayDateTo; ?>" class="datepicker" id="date_to" type="text" placeholder="dd-mm-jjjj" />
									</span>
								</div>
							</div>
							<hr />
							<h2 class="blue">Jouw gezelschap</h2>
							<p>Leuk dat je/jullie komen! In de vorige stap gaf je het volgende reisgezelschap aan. Wil je dit toch nog wijzigen? Dat kan, ga dan terug naar <a href="javascript:history.back()" title="Ga terug naar de vorige stap">de vorige stap</a>.</p>
							<div class="family">
								<div class="input-field">
									<?php $adults = isset($_GET['adults']) ? $_GET['adults'] : null; ?>
									<label for="adults">Volwassenen:</label>
									<span class="input-with-icon">
										<i class="adults"></i>
										<input name="adults" id="adults" type="number" placeholder="0" disabled="disabled" value="<?php echo $adults; ?>">
									</span>
								</div>
								<div class="input-field">
									<?php $children = isset($_GET['children']) ? $_GET['children'] : null; ?>
									<label for="children">Kinderen:</label>
									<span class="input-with-icon">
										<i class="children"></i>
										<input name="children" id="children" type="number" placeholder="0" disabled="disabled" value="<?php echo $children; ?>">
									</span>
								</div>
								<div class="input-field">
									<?php $pets = isset($_GET['pets']) ? $_GET['pets'] : null; ?>
									<label for="pets">Huisdieren:</label>
									<span class="input-with-icon">
										<i class="pets"></i>
										<input name="pets" id="pets" type="number" placeholder="0" disabled="disabled" value="<?php echo $pets; ?>">
									</span>
								</div>
							</div>
							<hr />
							<h2 class="blue">Jouw gegevens</h2>
							<p>Om jouw reservering goed af te ronden, hebben we nog enkele gegevens van je nodig. Klik - nadat je alles goed gecontroleerd hebt - op "Reservering afronden" om je reservering te verzenden.</p>
							<p class="red"><strong>Let op!</strong> Jouw reservering is pas definitief als je een bevesting per e-mail ontvangen hebt. Wij proberen binnen 24 uur na ontvangst een bevestiging te sturen.</p>
							<?php the_content(); ?>
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
										<strong id="total-price">€ <?php echo number_format($total, 2); ?></strong>
									</li>
								</ul>
								<?php endif; ?>
							</div>
						</div>
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
