<?php get_header(); ?>

<main role="main">
    <section class="hero">
        <div class="slider" data-auto="true">
            <div class="slides">
                <div class="slide" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');"></div>
            </div>
            <a href="#" class="slide-nav previous"><i class="icon-chevron-left"></i></a>
            <a href="#" class="slide-nav next"><i class="icon-chevron-right"></i></a>
        </div>
        <div class="content-wrapper">
            <a href="/" title="Camping de l'Eau Rouge" class="logo-holder">
                <img class="logo tiny" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" title="Domaine de l'Eau Rouge" alt="Domaine de l'Eau Rouge" />
            </a>
            <h1 class=""><?php the_title(); ?></h1>
            <h2 class=""><?php the_field('subtitle'); ?></h2>
            <div class="usps">
                <ul>
                    <?php while( have_rows('usps') ): the_row(); ?>
                        <li><i class="icon-check"></i><?php the_sub_field('usp'); ?></li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="content-wrapper">
            <div class="column-holder">
                <div class="column main">
                    <div class="content-wrapper">
                        <?php the_content(); ?>
                        <ul class="simple-gallery">
                            <?php while( have_rows('images') ): the_row(); ?>
                                <li>
                                    <img src="<?php the_sub_field('image'); ?>" />
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
                <div class="column aside">
                    <div class="box red">
                        <div class="content-wrapper">
                            <?php the_field('extra_information'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section turqoise" id="accommodation-booker">
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
            $pricePeriods = get_field('price_periods', get_the_id());


            if ($pricePeriods) {
                //GET BUNDLES
                $bundles;

                $meta_query = array(
                    'key'       => 'for_accommodations',
                    'value'     => get_the_id(),
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
            }
        ?>
            <div class="content-wrapper">
                <div class="column-holder stick-in-parent-parent">
                    <div class="column main">
                        <div class="content-wrapper">
                            <h2 class="red"><?php the_field('book_title', 'options'); ?></h2>
                            <?php the_field('book_intro', 'options'); ?>
                            <hr class="blue" />
                            <?php global $wp; ?>
                            <form id="booking-details-form" action="<?php echo home_url($wp->request); ?>" method="GET">
                                <input type="hidden" id="accommodation_id" name="accommodation_id" value="<?php echo get_the_id(); ?>"/>
                                <?php get_template_part('/elements/accommodation-booker/selected-period'); ?>
                                <hr class="blue" />
                                <?php get_template_part('/elements/accommodation-booker/selected-family'); ?>
                                <div id="ask-for-family-members-box">
                                    <?php get_template_part('/elements/accommodation-booker/selected-family-members'); ?>
                                </div>
                                <hr class="blue" />
                                <div id="selected-extras" class="can-reload">
                                    <?php get_template_part('/elements/accommodation-booker/selected-extras'); ?>
                                </div>
                                <hr class="blue" />
                            </form>
                            <div id="formidable-form" class="can-reload">
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
                    </div>
                    <div class="column aside">
                        <div class="stick-in-parent">
                            <div class="box green can-reload" id="box-price-detail">
                                <div class="content-wrapper">
                                    <?php the_field('price_intro', 'options'); ?>
                                    <?php if($isAvailable && $pricePeriods && $currentPricePeriod ): ?>                
                                        <div class="box yellow booking-summary">
                                            <div class="content-wrapper narrow">
                                                <h4 class="red"><?php echo get_the_title(get_the_id()); ?></h3>
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
                                                <?php if($current_bundle && $current_bundle->min_nights > 1): ?>
                                                    <span>1 x <?php _e('arrangement', 'eaurouge'); ?></span>
                                                <?php else: ?>
                                                    <span><?php echo $nights; ?> x <?php _e('nachten', 'eaurouge'); ?></span>
                                                <?php endif; ?>
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
                                            $extras = get_field('extras', get_the_id());
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
                                            <?php elseif($current_bundle->has_discount): ?>
                                                <?php 
                                                    $discount = $current_bundle->discount; 
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
                                            <?php if(get_field('collateral', get_the_id())): ?>
                                                <li class="caution">
                                                    <span><?php _e('Waarborg', 'eaurouge'); ?>:</span>
                                                    <strong>€ <?php echo number_format(get_field('collateral', get_the_id()), 2); ?><br /></strong>
                                                </li>
                                            <?php endif; ?>
                                            <li class="info">
                                                <?php the_field('note_below_price', 'options'); ?>
                                            </li>
                                        </ul>
                                    <?php elseif(!$isAvailable): ?>
                                        <p class="white"><?php _e('Deze accommodatie is helaas niet beschikbaar in de gekozen periode.', 'eaurouge'); ?></p>
                                    <?php else: ?>
                                        <p class="white"><?php _e('We hebben meer gegevens <br />nodig om de actuele prijs <br />te berekenen.', 'eaurouge'); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
