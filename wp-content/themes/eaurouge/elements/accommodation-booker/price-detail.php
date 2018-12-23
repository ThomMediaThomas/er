<div class="box green" id="box-price-detail">
    <div class="content-wrapper">
        <?php the_field('price_intro'); ?>
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
        }
        ?>
        <?php if($pricePeriods && $currentPricePeriod): ?>
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
                </li>
                <?php
                $extras = get_field('extras', $_GET['accommodation_id']);
                $selected_extras = $_GET['extras'];
                $extra_counter = 0;

                if ($selected_extras):
                    foreach ($selected_extras as $extra_key):
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
                <li class="info">
                    <?php the_field('note_below_price'); ?>
                </li>
            </ul>
        <?php endif; ?>
    </div>
</div>
