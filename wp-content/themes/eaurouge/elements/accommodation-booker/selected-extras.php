<?php the_field('extras_intro', 'options'); ?>
<?php 
    $selected_extras = $_GET['extras']; 

    $hasDates  = !empty($_GET['date_from']) && !empty($_GET['date_to']);

    if ($hasDates) {
        $date_from = date_create_from_format('d-m-Y', $_GET['date_from']);
        $date_from_comparable = date_format($date_from,'Ymd');
        $date_to = date_create_from_format('d-m-Y', $_GET['date_to']);
        $date_to_comparable = date_format($date_to,'Ymd');
    }

    $pricePeriods = get_field('price_periods', get_the_id());

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
    }

    $disabled_extras_for_period = null;
    if ($currentPricePeriod && $currentPricePeriod["disabled_extras_for_period"]) {
        $disabled_extras_for_period = $currentPricePeriod["disabled_extras_for_period"];
    }
?>
<?php if(have_rows('extras', get_the_id())): ?>
    <?php while( have_rows('extras', get_the_id()) ): the_row(); ?>
        <?php
            $key = get_sub_field('key');
            $selected = $selected_extras ? in_array($key, $selected_extras) : false;

            if (!$selected) {
                $selected = get_sub_field('default');
            }
        ?>
        <?php if (($disabled_extras_for_period && !in_array($key, $disabled_extras_for_period)) || !$disabled_extras_for_period) : ?>
            <div class="input-field">
                    <label for="<?php echo $key; ?>" class="checkbox">
                    <input type="checkbox" <?php if($selected): ?>checked="checked"<?php endif; ?> class="extras-for-stay" name="extras[]" value="<?php echo $key; ?>" id="<?php echo $key; ?>" />
                    <span class="check"></span>
                    <?php $per_night = get_sub_field('price_is_per_night'); ?>
                    <?php the_sub_field('title'); ?> (+ € <?php echo number_format(get_sub_field('price'), 2); ?> <?php if ($per_night): ?><?php _e('per nacht', 'eaurouge'); ?><?php else: ?><?php _e('per verblijf', 'eaurouge'); ?><?php endif; ?>)
                    <span class="checkbox-info"><?php the_sub_field('info'); ?></span></label>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php else: ?>
    <p><strong><?php the_field('no_extras_for_accommodation'); ?></strong></p>
<?php endif; ?>
