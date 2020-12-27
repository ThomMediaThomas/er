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
    }
?>
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
</div>