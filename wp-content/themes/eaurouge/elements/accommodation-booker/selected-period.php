<?php the_field('period_intro'); ?>
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
