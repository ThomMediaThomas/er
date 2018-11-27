<section id="quick-booking">
    <div class="hide-on-mobile">
        <div class="tabs">
            <a href="#tab-camping" class="tab camping active green" title="Kamperen"><i class="camping"></i><?php _e('Kamperen', 'eaurouge'); ?></a>
            <a href="#tab-chalet" class="tab chalet blue" title="Chalet huren"><i class="chalet"></i><?php _e('Chalet huren', 'eaurouge'); ?></a>
        </div>
        <div class="tabs-content">
            <div class="tab-content active green" id="tab-camping">
                <form id="camping-search" class="quick-booking-form" method="GET" action="/boeken">
                    <input type="hidden" name="stay_type" value="camping" />
                    <div class="input-field date">
                        <label for="stay_date_from" class="white"><?php _e('Van', 'eaurouge'); ?>:</label>
                        <span class="input-with-icon">
                            <i class="date"></i>
                            <input name="stay_date_from" class="datepicker" id="stay_date_from" type="text" autocomplete="off" placeholder="dd-mm-jjjj" />
                        </span>
                    </div>
                    <div class="input-field date">
                        <label for="stay_date_to" class="white"><?php _e('Tot', 'eaurouge'); ?>:</label>
                        <span class="input-with-icon">
                            <i class="date"></i>
                            <input name="stay_date_to" class="datepicker" id="stay_date_to" type="text" autocomplete="off" placeholder="dd-mm-jjjj" />
                        </span>
                    </div>
                    <div class="input-field vehicle">
                        <label for="vehicle" class="white"><?php _e('Kampeermiddel', 'eaurouge'); ?>:</label>
                        <select name="vehicle" id="vehicle">
                            <option value=""><?php _e('Maak een keuze', 'eaurouge'); ?></option>
                            <option value="tent"><?php _e('Tent', 'eaurouge'); ?></option>
                            <option value="caravan"><?php _e('Caravan', 'eaurouge'); ?></option>
                            <option value="camper"><?php _e('Camper', 'eaurouge'); ?></option>
                            <option value="folding_car"><?php _e('Vouwwagen', 'eaurouge'); ?></option>
                            <option value="other"><?php _e('Anders', 'eaurouge'); ?></option>
                        </select>
                    </div>
                    <div class="input-field guests">
                        <label for="adults" class="white"><?php _e('Aantal personen', 'eaurouge'); ?>:</label>
                        <div class="counter">
                            <span class="number-input">
                                <span class="input-with-icon">
                                    <i class="adults"></i>
                                    <input name="adults" id="adults" type="number" placeholder="0" />
                                </span>
                                <i class="up">+</i>
                                <i class="down">-</i>
                            </span>
                        </div>
                        <div class="counter">
                            <span class="number-input">
                                <span class="input-with-icon">
                                    <i class="children"></i>
                                    <input name="children" id="children" type="number" placeholder="0" />
                                </span>
                                <i class="up">+</i>
                                <i class="down">-</i>
                            </span>
                        </div>
                    </div>
                    <div class="input-field submit">
                        <a class="button red submit-quick-booking-form" href="/boeken" title="Zoeken naar accommodaties"><?php _e('Zoeken', 'eaurouge'); ?> <i class="icon-chevron-right"></i></a>
                    </div>
                </form>
            </div>
            <div class="tab-content blue" id="tab-chalet">
                <form id="chalet-search" class="quick-booking-form" method="GET" action="/boeken">
                    <input type="hidden" name="stay_type" value="chalet" />
                    <div class="input-field date">
                        <label for="stay_date_from" class="white"><?php _e('Van', 'eaurouge'); ?>:</label>
                        <span class="input-with-icon">
                            <i class="date"></i>
                            <input name="stay_date_from" class="datepicker" id="stay_date_from" type="text" placeholder="dd-mm-jjjj" />
                        </span>
                    </div>
                    <div class="input-field date">
                        <label for="stay_date_to" class="white"><?php _e('Tot', 'eaurouge'); ?>:</label>
                        <span class="input-with-icon">
                            <i class="date"></i>
                            <input name="stay_date_to" class="datepicker" id="stay_date_to" type="text" placeholder="dd-mm-jjjj" />
                        </span>
                    </div>
                    <div class="input-field accommodation">
                        <label for="accommodation_type" class="white"><?php _e('Soort verblijf', 'eaurouge'); ?>:</label>
                        <select name="accommodation_type" id="accommodation_type">
                            <option value=""><?php _e('Maak een keuze', 'eaurouge'); ?></option>
                            <option value="chalet-4"><?php _e('4-persoons chalet', 'eaurouge'); ?></option>
                            <option value="chalet-6"><?php _e('6-persoons chalet', 'eaurouge'); ?></option>
                        </select>
                    </div>
                    <div class="input-field submit">
                        <a class="button red submit-quick-booking-form" href="/boeken" title="Zoeken naar accommodaties"><?php _e('Zoeken', 'eaurouge'); ?> <i class="icon-chevron-right"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="show-on-mobile">
        <a class="button small red" href="/boeken" title="Zoeken naar accommodaties"><?php _e('Direct reserveren', 'eaurouge'); ?> <i class="icon-chevron-right"></i></a>
    </div>
</section>
