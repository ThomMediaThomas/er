<?php 
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
        
        //GET PERIODS
        $periods;

        $meta_query = array(
            'key'       => 'stay_type',
            'value'     => get_field('type', get_the_id()),
            'compare'   => 'LIKE',
        );

        $periods = new WP_query(); 
        $periods->query(array(
            'post_type' => array('period'),
            'meta_query' => array($meta_query)
        )); 

        $current_periods = array_filter($periods->posts, function ($period) use ($date_from_comparable, $date_to_comparable) {
            return 
                ($date_from_comparable >= $period->date_from && $date_from_comparable <= $period->date_to) ||
                ($date_to_comparable >= $period->date_from && $date_to_comparable <= $period->date_to);
        });

        $current_period = reset($current_periods);

        $arrival_date_available = true;
        $departure_date_available = true;

        if ($current_period) {
            $arrival_date_available = false;
            $departure_date_available = false;

            $current_period_arrival_days = $current_period->available_days_arrival;
            $requested_arrival_day = $date_from->format('D');
            $arrival_date_available = in_array($requested_arrival_day, $current_period_arrival_days);

            $current_period_departure_days = $current_period->available_days_departure;
            $requested_departure_day = $date_to->format('D');
            $departure_date_available = in_array($requested_departure_day, $current_period_departure_days);
        }
        //END GET PERIODS
    }
?>

<?php the_field('period_intro', 'options'); ?>
<div class="period">
    <div class="input-field">
        <?php $stayDateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : null; ?>
        <label for="stay_date_from"><?php _e('Van', 'eaurouge'); ?>:</label>
        <span class="input-with-icon">
            <i class="date"></i>
            <input name="date_from" value="<?php echo $stayDateFrom; ?>" class="datepicker required from-related-to" id="date_from" autocomplete="off" type="text" placeholder="dd-mm-jjjj" />
        </span>
    </div>
    <div class="input-field">
        <?php $stayDateTo = isset($_GET['date_to']) ? $_GET['date_to'] : null; ?>
        <label for="stay_date_to"><?php _e('Tot', 'eaurouge'); ?>:</label>
        <span class="input-with-icon">
            <i class="date"></i>
            <input name="date_to" value="<?php echo $stayDateTo; ?>" class="datepicker required to-related-from" id="date_to" autocomplete="off" type="text" placeholder="dd-mm-jjjj" />
        </span>
    </div>
</div>
<div id="period-info" class="can-reload">
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
    <?php if(!$arrival_date_available || !$departure_date_available) : ?>
        <div class="availability-info box blue">
            <div class="content-wrapper">
                <span class="white smaller regular"><?php _e('Voor deze periode hanteren we vaste aankomst en/of vertrekdagen.', 'eaurouge'); ?></span><br />
                <span class="white smaller regular">
                    <span class="day-label"><?php _e('Aankomst op: ', 'eaurouge'); ?></span>
                    <?php foreach( $current_period->available_days_arrival as $key => $day ) { 
                        _e($day, 'eaurouge');
                        if ($key < count($current_period->available_days_arrival) - 1) {
                            echo ', '; 
                        }
                    }?> <br />
                    <span class="day-label"><?php _e('Vertrek op: ', 'eaurouge'); ?></span>
                    <?php foreach( $current_period->available_days_departure as $key => $day ) { 
                        _e($day, 'eaurouge');
                        if ($key < count($current_period->available_days_departure) - 1) {
                            echo ', '; 
                        }
                    }?> <br />
                </span>
            </div>
        </div>
    <?php endif; ?>    
</div>