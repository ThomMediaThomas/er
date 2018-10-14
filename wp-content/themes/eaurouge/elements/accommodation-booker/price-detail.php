<div class="box green" id="box-price-detail">
    <div class="content-wrapper">
        <h3 class="yellow"><span class="white sub">Overzicht van</span> jouw verblijf</h3>
        <?php
        $adults = intval($_GET['adults']);
        $children = intval($_GET['children']);
        $babies = intval($_GET['babies']);
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
                    <span><?php echo $nights; ?> x nacht</span>
                    <strong>€ <?php echo number_format($price, 2); ?></strong>
                </li>
                <li>
                    <?php
                    $price = $nights * $adults * floatval($currentPricePeriod['price_per_adult']);
                    $total += $price;
                    ?>
                    <span><?php echo $adults; ?> x volwassene</span>
                    <strong>€ <?php echo number_format($price, 2); ?></strong>
                </li>
                <li>
                    <?php
                    $price = $nights * $children * floatval($currentPricePeriod['price_per_child']);
                    $total += $price;
                    ?>
                    <span><?php echo $children; ?> x kind (4 t/m 15 jaar)</span>
                    <strong>€ <?php echo number_format($price, 2); ?></strong>
                </li>
                <li>
                    <?php
                    $price = $nights * $babies * floatval($currentPricePeriod['price_per_baby']);
                    $total += $price;
                    ?>
                    <span><?php echo $babies; ?> x kind (0 t/m 3 jaar)</span>
                    <strong>€ <?php echo number_format($price, 2); ?></strong>
                </li>
                <li>
                    <?php
                    $price = $nights * $pets * floatval($currentPricePeriod['price_per_dog']);
                    $total += $price;
                    ?>
                    <span><?php echo $pets; ?> x huisdier</span>
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
                    $price = $nights * ($adults + $children + $babies) * floatval($currentPricePeriod['tourist_tax_per_night']);
                    $total += $price;
                    ?>
                    <span><?php echo ($adults + $children + $babies); ?> x toeristenbelasting</span>
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
