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

    if ($pricePeriods) {
        $currentPricePeriod = array_filter($pricePeriods, function ($period) use ($date_from_comparable) {
            return $date_from_comparable >= $period['period_from'] && $date_from_comparable <= $period['period_to'];
        });

        if ($currentPricePeriod) {
            $currentPricePeriod = reset($currentPricePeriod);

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

            $price += $nights * floatval($currentPricePeriod['price_per_night']);
            $price += $nights * $adults * floatval($currentPricePeriod['price_per_adult']);
            $price += $nights * $children * floatval($currentPricePeriod['price_per_child']);
            $price += $nights * $babies * floatval($currentPricePeriod['price_per_baby']);
            $price += $nights * $pets * floatval($currentPricePeriod['price_per_dog']);
            $price += $nights * floatval($currentPricePeriod['electricty_per_night']);
            $price += $nights * ($adults + $children + $babies) * floatval($currentPricePeriod['tourist_tax_per_night']);
            $price += floatval($currentPricePeriod['booking_costs_per_stay']);

            if ($extras && $defaultExtras) {
                foreach ($defaultExtras as $defaultExtra) {
                    $amount = $defaultExtra['price_is_per_night'] ? $nights : 1;
                    $price += $amount * $defaultExtra['price'];
                }

            }

            $url = '/boeken/gegevens';
            $url .= '?accommodation_id=' . get_the_ID();
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
    }
?>
<div class="accommodation-preview">
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
        <ul class="usps small">
            <?php while( have_rows('usps') ): the_row(); ?>
                <li><i class="icon-check"></i><?php the_sub_field('usp'); ?></li>
            <?php endwhile; ?>
        </ul>
        <?php if ($hasPrice) { ?>
            <div class="bottom">
                <div class="bottom-left">
                    <span>Prijs voor het verblijf </span>
                    <strong>€ <?php echo number_format($price, 2); ?></strong>
                    <span>incl. toeristenbelasting</span>
                </div>
                <a class="button yellow small" href="<?php echo $url; ?>">Verblijf boeken<i class="icon-chevron-right"></i></a>
            </div>
        <?php } else { ?>
            <div class="bottom">
                <div class="bottom-left">
                    <span>We hebben meer gegevens<br /> nodig om de actuele prijs <br />te berekenen.</span>
                </div>
                <a class="button yellow small disabled">Verblijf boeken<i class="icon-chevron-right"></i></a>
            </div>
        <?php } ?>
    </div>
</div>
