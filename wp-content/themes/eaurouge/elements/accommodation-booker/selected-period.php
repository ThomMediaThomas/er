<?php the_field('period_intro'); ?>
<div class="period">
    <div class="input-field">
        <?php $stayDateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : null; ?>
        <label for="stay_date_from">Van:</label>
        <span class="input-with-icon">
            <i class="date"></i>
            <input name="date_from" value="<?php echo $stayDateFrom; ?>" class="datepicker required" id="date_from" type="text" placeholder="dd-mm-jjjj">
        </span>
    </div>
    <div class="input-field">
        <?php $stayDateTo = isset($_GET['date_to']) ? $_GET['date_to'] : null; ?>
        <label for="stay_date_to">Tot:</label>
        <span class="input-with-icon">
            <i class="date"></i>
            <input name="date_to" value="<?php echo $stayDateTo; ?>" class="datepicker required" id="date_to" type="text" placeholder="dd-mm-jjjj" />
        </span>
    </div>
</div>
