<?php global $wp; ?>
<form method="GET" id="accommodation-finder-filters" action="<?php echo home_url($wp->request); ?>">
    <div class="box yellow">
        <div class="content-wrapper">
            <h3 class="red"><?php _e('Verblijf', 'eaurouge'); ?></h3>

            <?php $forcedType = isset($_GET['forced_type']) ? $_GET['forced_type'] : null; ?>
            <input type="hidden" name="forced_type" id="forced_type" value="<?php echo $forcedType; ?>" />
            
            <div class="input-field">
                <?php $stayType = isset($_GET['stay_type']) ? $_GET['stay_type'] : null; ?>
                <label for="stay_type" class="white"><?php _e('Type', 'eaurouge'); ?>:</label>
                <select name="stay_type" id="stay_type">
                    <option value=""><?php _e('Maak een keuze', 'eaurouge'); ?></option>
                    <option value="chalet" <?php if($stayType == 'chalet'): ?>selected="selected"<?php endif; ?>><?php _e('Chalet', 'eaurouge'); ?></option>
                    <option value="camping" <?php if($stayType == 'camping'): ?>selected="selected"<?php endif; ?>><?php _e('Kampeerplaats', 'eaurouge'); ?></option>
                </select>
            </div>
            <div class="input-field" id="stay_type_camping">
                <?php $vehicle = isset($_GET['vehicle']) ? $_GET['vehicle'] : null; ?>
                <label for="vehicle" class="white"><?php _e('Kampeermiddel', 'eaurouge'); ?>:</label>
                <select name="vehicle" id="vehicle">
                    <option value=""><?php _e('Maak een keuze', 'eaurouge'); ?></option>
                    <option value="tent" <?php if($vehicle == 'tent'): ?>selected="selected"<?php endif; ?>><?php _e('Tent', 'eaurouge'); ?></option>
                    <option value="caravan" <?php if($vehicle == 'caravan'): ?>selected="selected"<?php endif; ?>><?php _e('Caravan', 'eaurouge'); ?></option>
                    <option value="camper" <?php if($vehicle == 'camper'): ?>selected="selected"<?php endif; ?>><?php _e('Camper', 'eaurouge'); ?></option>
                    <option value="folding_car" <?php if($vehicle == 'folding_car'): ?>selected="selected"<?php endif; ?>><?php _e('Vouwwagen', 'eaurouge'); ?></option>
                    <option value="other" <?php if($vehicle == 'other'): ?>selected="selected"<?php endif; ?>><?php _e('Anders', 'eaurouge'); ?></option>
                </select>
            </div>
            <div class="input-field" id="stay_type_chalet">
                <?php $accommodation_type = isset($_GET['accommodation_type']) ? $_GET['accommodation_type'] : null; ?>
                <label for="accommodation_type" class="white"><?php _e('Soort verblijf', 'eaurouge'); ?>:</label>
                <select name="accommodation_type" id="accommodation_type">
                    <option value=""><?php _e('Maak een keuze', 'eaurouge'); ?></option>
                    <option value="chalet-4" <?php if($accommodation_type == 'chalet-4'): ?>selected="selected"<?php endif; ?>><?php _e('4-persoons chalet', 'eaurouge'); ?></option>
                    <option value="chalet-4-br" <?php if($accommodation_type == 'chalet-4-br'): ?>selected="selected"<?php endif; ?>><?php _e('4-persoons chalet aan de bosrand', 'eaurouge'); ?></option>
                    <option value="chalet-6" <?php if($accommodation_type == 'chalet-6'): ?>selected="selected"<?php endif; ?>><?php _e('6-persoons chalet', 'eaurouge'); ?></option>
                </select>
            </div>
            <div class="input-field">
                <?php $stayDateFrom = isset($_GET['stay_date_from']) ? $_GET['stay_date_from'] : null; ?>
                <label for="stay_date_from" class="white"><?php _e('Van', 'eaurouge'); ?>:</label>
                <span class="input-with-icon">
                    <i class="date"></i>
                    <input name="stay_date_from" value="<?php echo $stayDateFrom; ?>" class="datepicker from-related-to" autocomplete="off" id="stay_date_from" type="text" placeholder="dd-mm-jjjj">
                </span>
            </div>
            <div class="input-field">
                <?php $stayDateTo = isset($_GET['stay_date_to']) ? $_GET['stay_date_to'] : null; ?>
                <label for="stay_date_to" class="white"><?php _e('Tot', 'eaurouge'); ?>:</label>
                <span class="input-with-icon">
                    <i class="date"></i>
                    <input name="stay_date_to" value="<?php echo $stayDateTo; ?>" class="datepicker to-related-from" autocomplete="off" id="stay_date_to" type="text" placeholder="dd-mm-jjjj" />
                </span>
            </div>
        </div>
    </div>
    <div class="box green">
        <div class="content-wrapper">
            <h3 class="yellow">Reisgezelschap</h3>
            <div class="input-field">
                <?php $adults = isset($_GET['adults']) ? $_GET['adults'] : null; ?>
                <label for="adults" class="white"><?php _e('Volwassenen', 'eaurouge'); ?>:</label>
                <div class="counter">
                    <span class="number-input">
                        <span class="input-with-icon">
                            <i class="adults"></i>
                            <input name="adults" value="<?php echo $adults; ?>" id="adults" type="number" placeholder="0" />
                        </span>
                        <i class="up">+</i>
                        <i class="down">-</i>
                    </span>
                </div>
            </div>
            <div class="input-field">
                <?php $children = isset($_GET['children']) ? $_GET['children'] : null; ?>
                <label for="children" class="white"><?php _e('Kinderen (4 t/m 15 jaar)', 'eaurouge'); ?>:</label>
                <div class="counter">
                    <span class="number-input">
                        <span class="input-with-icon">
                            <i class="children"></i>
                            <input name="children" value="<?php echo $children; ?>" id="children" type="number" placeholder="0" />
                        </span>
                        <i class="up">+</i>
                        <i class="down">-</i>
                    </span>
                </div>
            </div>
            <div class="input-field">
                <?php $babies = isset($_GET['babies']) ? $_GET['babies'] : null; ?>
                <label for="babies" class="white"><?php _e('Kinderen (0 t/m 3 jaar)', 'eaurouge'); ?>:</label>
                <div class="counter">
                    <span class="number-input">
                        <span class="input-with-icon">
                            <i class="babies"></i>
                            <input name="babies" value="<?php echo $babies; ?>" id="babies" type="number" placeholder="0" />
                        </span>
                        <i class="up">+</i>
                        <i class="down">-</i>
                    </span>
                </div>
            </div>
            <div class="input-field">
                <?php $pets = isset($_GET['pets']) ? $_GET['pets'] : null; ?>
                <label for="pets" class="white"><?php _e('Huisdieren', 'eaurouge'); ?>:</label>
                <div class="counter">
                    <span class="number-input">
                        <span class="input-with-icon">
                            <i class="pets"></i>
                            <input name="pets" value="<?php echo $pets; ?>" id="pets" type="number" placeholder="0" />
                        </span>
                        <i class="up">+</i>
                        <i class="down">-</i>
                    </span>
                </div>
                <span class="smaller white input-sub regular">
                    <?php _e('Kamperen: maximaal 2', 'eaurouge'); ?><br />
                    <?php _e('Chalet: maximaal 1', 'eaurouge'); ?>
                </span>
            </div>
        </div>
    </div>
    <div class="input-field">
        <?php the_field('above_search_button'); ?>
        <a class="button red submit-parent-form"><?php _e('Zoeken', 'eaurouge'); ?> <i class="icon-chevron-right"></i></a>
        <?php the_field('below_search_button'); ?>
    </div>
</form>
