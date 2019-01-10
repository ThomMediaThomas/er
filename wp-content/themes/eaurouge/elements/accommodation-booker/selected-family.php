<?php the_field('family_intro'); ?>
<div class="family">
    <div class="input-field">
        <?php $adults = isset($_GET['adults']) ? $_GET['adults'] : 1; ?>
        <label for="adults"><?php _e('Volwassenen', 'eaurouge'); ?>:</label>
        <div class="counter">
            <span class="number-input">
                <span class="input-with-icon">
                    <i class="adults"></i>
                    <input name="adults" id="adults" class="required" type="number" placeholder="0" value="<?php echo $adults; ?>">
                </span>
                <i class="up">+</i>
                <i class="down">-</i>
            </span>
        </div>
    </div>
    <div class="input-field">
        <?php $children = isset($_GET['children']) ? $_GET['children'] : null; ?>
        <label for="children"><?php _e('Kinderen (4 t/m 15 jaar)', 'eaurouge'); ?>:</label>
        <div class="counter">
            <span class="number-input">
                <span class="input-with-icon">
                    <i class="children"></i>
                    <input name="children" id="children" type="number" placeholder="0" value="<?php echo $children; ?>">
                </span>
                <i class="up">+</i>
                <i class="down">-</i>
            </span>
        </div>
    </div>
    <div class="input-field">
        <?php $babies = isset($_GET['babies']) ? $_GET['babies'] : null; ?>
        <label for="babies"><?php _e('Kinderen (0 t/m 3 jaar)', 'eaurouge'); ?>:</label>
        <div class="counter">
            <span class="number-input">
                <span class="input-with-icon">
                    <i class="babies"></i>
                    <input name="babies" id="babies" type="number" placeholder="0" value="<?php echo $babies; ?>">
                </span>
                <i class="up">+</i>
                <i class="down">-</i>
            </span>
        </div>
    </div>
    <div class="input-field">
        <?php $pets = isset($_GET['pets']) ? $_GET['pets'] : null; ?>
        <label for="pets"><?php _e('Huisdieren', 'eaurouge'); ?>:</label>
        <div class="counter">
            <span class="number-input">
                <span class="input-with-icon">
                    <i class="pets"></i>
                    <input name="pets" id="pets" type="number" placeholder="0" value="<?php echo $pets; ?>">
                </span>
                <i class="up">+</i>
                <i class="down">-</i>
            </span>
        </div>
    </div>
</div>
