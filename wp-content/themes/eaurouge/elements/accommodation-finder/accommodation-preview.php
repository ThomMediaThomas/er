<?php
    $title = get_the_title();
    $hasDates  = !empty($_GET['stay_date_from']) && !empty($_GET['stay_date_to']);
    $hasPrice = false;

    if ($hasDates) {
        $date_from = date_create_from_format('d-m-Y', $_GET['stay_date_from']);
        $date_from_comparable = date_format($date_from,'Ymd');
        $date_to = date_create_from_format('d-m-Y', $_GET['stay_date_to']);
        $date_to_comparable = date_format($date_to,'Ymd');
        $nights = $date_to->diff($date_from)->format("%a");
    }

    $price = 0;
    $pricePeriods = get_field('price_periods');

    $url = get_permalink();
    $url .= '?accommodation_id=' . get_the_ID();

    if ($pricePeriods) {
        $accommodation_id = $post->ID;
        
        //GET BUNDLES
        $bundles;

        $meta_query = array(
            'key'       => 'for_accommodations',
            'value'     => $post->ID,
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

        if ($currentPricePeriod) {
            $hasPrice = true;
            $adults = intval($_GET['adults']);
            $children = intval($_GET['children']);
            $babies = intval($_GET['babies']);
            $pets = intval($_GET['pets']);

            $extras = get_field('extras');
            if ($extras) {
                $defaultExtras = array_filter($extras, function ($extra) {
                    return $extra['default'];
                });
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

            $price += $nights * floatval($pricePerNight);
            $price += $nights * $adults * floatval($currentPricePeriod['price_per_adult']);
            $price += $nights * $children * floatval($currentPricePeriod['price_per_child']);
            $price += $nights * $babies * floatval($currentPricePeriod['price_per_baby']);
            $price += $nights * $pets * floatval($currentPricePeriod['price_per_dog']);
            $price += $nights * floatval($currentPricePeriod['electricty_per_night']);
            $price += $nights * ($adults + $children + $babies) * floatval($currentPricePeriod['tourist_tax_per_night']);
            $price += floatval($currentPricePeriod['booking_costs_per_stay']);

            if ($extras && $defaultExtras) {
                foreach ($defaultExtras as $defaultExtra) {
                    $extra_key = $defaultExtra["key"];
                    if (($disabled_extras_for_period && !in_array($extra_key, $disabled_extras_for_period)) || !$disabled_extras_for_period) {
                        $amount = $defaultExtra['price_is_per_night'] ? $nights : 1;
                        $price += $amount * $defaultExtra['price'];
                    }
                }

            }

            $url .= '&date_from=' . $_GET['stay_date_from'];
            $url .= '&date_to=' . $_GET['stay_date_to'];
            $url .= '&adults=' . $_GET['adults'];
            $url .= '&children=' . $_GET['children'];
            $url .= '&babies=' . $_GET['babies'];
            $url .= '&pets=' . $_GET['pets'];

            if ($extras && $defaultExtras) {
                $joinedExtras = implode(',', array_map(function ($extra) {
                    return $extra['key'];
                }, $defaultExtras));

                $url .= '&extras[]=' . $joinedExtras;
            }
        }

        $isAvailable = (isset($currentPricePeriod['available']) && $currentPricePeriod['available']) || !isset($currentPricePeriod['available']);
    }
?>
<div class="accommodation-preview <?php if (!$isAvailable): ?>disabled<?php endif; ?>">
    <div class="left">
        <img class="image-larger" src="<?php echo get_the_post_thumbnail_url(); ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" />
        <ul class="images">
            <li>
                <a href="<?php echo get_the_post_thumbnail_url(); ?>" class="set-image active" title="<?php echo $title; ?>">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" />
                </a>
            </li>
            <?php while( have_rows('images') ): the_row(); ?>
                <li>
                    <a href="<?php the_sub_field('image'); ?>" class="set-image" title="<?php echo $title; ?>">
                        <img src="<?php the_sub_field('image'); ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" />
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>

    </div>
    <div class="right">
        <h3 class="red no-margin"><?php the_title(); ?></h3>
        <h4 class=""><?php the_field('subtitle'); ?></h4>
        <?php if (get_field('more_text')): ?>
            <a class="button green tiny discover-accommodation" title="<?php the_field('more_text'); ?>" href="<?php echo get_permalink(); ?>" target="_blank">
                <?php the_field('more_text'); ?> <i class="icon-chevron-right"></i>
            </a>
        <?php endif; ?> 
        <ul class="usps small">
            <?php while( have_rows('usps') ): the_row(); ?>
                <li><i class="icon-check"></i><?php the_sub_field('usp'); ?></li>
            <?php endwhile; ?>
        </ul>
        <div class="bottom">
            <div class="bottom-left">
                <?php if ($isAvailable && $hasPrice) { ?>
                    <span><?php _e('Prijs voor het verblijf', 'eaurouge'); ?> </span>
                    <?php if ($currentPricePeriod['has_discount']): ?>
                        <?php 
                            $discount = 0; 

                            if ($currentPricePeriod['discount_type'] == 'percentage') {
                                $discount = ($price/100) * $currentPricePeriod['discount'];
                            } else {
                                $discount = $currentPricePeriod['discount'];
                            }
                        ?>
                        <strong class="original-price">€ <?php echo number_format($price, 2); ?></strong>
                        <strong>€ <?php echo number_format($price - $discount, 2); ?></strong>
                    <?php elseif($current_bundle->has_discount): ?>
                        <?php 
                            $discount = $current_bundle->discount; 
                        ?>
                        <strong class="original-price">€ <?php echo number_format($price, 2); ?></strong>
                        <strong>€ <?php echo number_format($price - $discount, 2); ?></strong>                    
                    <?php else: ?>
                        <strong>€ <?php echo number_format($price, 2); ?></strong>
                    <?php endif; ?>
                <?php } elseif (!$isAvailable) { ?>
                    <span><?php _e('Niet beschikbaar <br />voor de door jullie <br />gekozen periode.', 'eaurouge'); ?></span>
                <?php } else { ?>
                    <span><?php _e('We hebben meer gegevens <br />nodig om de actuele prijs <br />te berekenen.', 'eaurouge'); ?></span>
                <?php } ?>
            </div>
            <?php if ($isAvailable) : ?>
                <a class="button yellow small" href="<?php echo $url; ?>#accommodation-booker">
                    <?php _e('Verblijf boeken', 'eaurouge'); ?><i class="icon-chevron-right"></i>
                </a>
            <?php endif; ?>
        </div>
        <?php if ($currentPricePeriod['notes_for_period']): ?>
            <div class="period-notes">
                <div class="period-notes-content">
                    <?php echo $currentPricePeriod['notes_for_period']; ?>
                </div>
            </div>
        <?php endif; ?> 
        <?php if ($current_bundle && $current_bundle->show_bundle_information): ?>
            <div class="bundle">
                <div class="bundle-header">
                    <img src="<?php echo get_the_post_thumbnail_url($current_bundle->ID); ?>" tilte="<?php echo $current_bundle->post_title; ?>" alt="<?php echo $current_bundle->post_title; ?>" />
                    <span><?php echo $current_bundle->post_title; ?></span>
                </div>
                <div class="bundle-content">
                    <?php echo $current_bundle->post_content; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
