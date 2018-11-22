<section id="quick-booking">
    <div class="hide-on-mobile">
        <div class="tabs">
            <a href="#tab-camping" class="tab camping active green" title="Kamperen"><i class="camping"></i>Kamperen</a>
            <a href="#tab-chalet" class="tab chalet blue" title="Chalet huren"><i class="chalet"></i>Chalet huren</a>
        </div>
        <div class="tabs-content">
            <div class="tab-content active green" id="tab-camping">
                <form id="camping-search" class="quick-booking-form" method="GET" action="/boeken">
                    <input type="hidden" name="stay_type" value="camping" />
                    <div class="input-field date">
                        <label for="stay_date_from" class="white">Van:</label>
                        <span class="input-with-icon">
                            <i class="date"></i>
                            <input name="stay_date_from" class="datepicker" id="stay_date_from" type="text" autocomplete="off" placeholder="dd-mm-jjjj" />
                        </span>
                    </div>
                    <div class="input-field date">
                        <label for="stay_date_to" class="white">Tot:</label>
                        <span class="input-with-icon">
                            <i class="date"></i>
                            <input name="stay_date_to" class="datepicker" id="stay_date_to" type="text" autocomplete="off" placeholder="dd-mm-jjjj" />
                        </span>
                    </div>
                    <div class="input-field vehicle">
                        <label for="vehicle" class="white">Kampeermiddel:</label>
                        <select name="vehicle" id="vehicle">
                            <option value="">Maak een keuze</option>
                            <option value="tent">Tent</option>
                            <option value="caravan">Caravan</option>
                            <option value="camper">Camper</option>
                            <option value="folding_car">Vouwwagen</option>
                            <option value="other">Anders</option>
                        </select>
                    </div>
                    <div class="input-field guests">
                        <label for="adults" class="white">Aantal personen:</label>
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
                        <a class="button red submit-quick-booking-form" href="/boeken" title="Zoeken naar accommodaties">Zoeken <i class="icon-chevron-right"></i></a>
                    </div>
                </form>
            </div>
            <div class="tab-content blue" id="tab-chalet">
                <form id="chalet-search" class="quick-booking-form" method="GET" action="/boeken">
                    <input type="hidden" name="stay_type" value="chalet" />
                    <div class="input-field date">
                        <label for="stay_date_from" class="white">Van:</label>
                        <span class="input-with-icon">
                            <i class="date"></i>
                            <input name="stay_date_from" class="datepicker" id="stay_date_from" type="text" placeholder="dd-mm-jjjj" />
                        </span>
                    </div>
                    <div class="input-field date">
                        <label for="stay_date_to" class="white">Tot:</label>
                        <span class="input-with-icon">
                            <i class="date"></i>
                            <input name="stay_date_to" class="datepicker" id="stay_date_to" type="text" placeholder="dd-mm-jjjj" />
                        </span>
                    </div>
                    <div class="input-field accommodation">
                        <label for="accommodation_type" class="white">Soort verblijf:</label>
                        <select name="accommodation_type" id="accommodation_type">
                            <option value="">Maak een keuze</option>
                            <option value="chalet-4">4-persoons chalet</option>
                            <option value="chalet-6">6-persoons chalet</option>
                        </select>
                    </div>
                    <div class="input-field submit">
                        <a class="button red submit-quick-booking-form" href="/boeken" title="Zoeken naar accommodaties">Zoeken <i class="icon-chevron-right"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="show-on-mobile">
        <a class="button small red" href="/boeken" title="Zoeken naar accommodaties">Direct reserveren <i class="icon-chevron-right"></i></a>
    </div>
</section>
