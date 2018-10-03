<section id="quick-booking">
    <div class="tabs">
        <a href="#tab-camping" class="tab camping active yellow" title="Kamperen"><i class="camping"></i>Kamperen</a>
        <a href="#tab-chalet" class="tab chalet green" title="Chalet huren"><i class="chalet"></i>Chalet huren</a>
    </div>
    <div class="tabs-content">
        <div class="tab-content active yellow" id="tab-camping">
            <form id="camping-search">
                <div class="input-field date">
                    <label for="date_from" class="white">Van:</label>
                    <input name="date_from" id="date_from" class="with-icon date" type="text" placeholder="dd-mm-jjjj" />
                </div>
                <div class="input-field date">
                    <label for="date_to" class="white">Tot:</label>
                    <input name="date_to" id="date_to" class="with-icon date" type="text" placeholder="dd-mm-jjjj" />
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
                            <input name="adults" id="adults" class="with-icon adults" type="number" placeholder="0" />
                            <i class="up">+</i>
                            <i class="down">-</i>
                        </span>
                    </div>
                    <div class="counter">
                        <span class="number-input">
                            <input name="children" id="children" class="with-icon children" type="number" placeholder="0" />
                            <i class="up">+</i>
                            <i class="down">-</i>
                        </span>
                    </div>
                </div>
                <div class="input-field submit">
                    <a class="button red" href="/boeken" title="Zoeken naar accommodaties">Zoeken <i class="icon-chevron-right"></i></a>
                </div>
            </form>
        </div>
        <div class="tab-content green" id="tab-chalet">
            <form id="chalet-search">
                <div class="input-field date">
                    <label for="date_from" class="white">Van:</label>
                    <input name="date_from" id="date_from" class="with-icon date" type="text" placeholder="dd-mm-jjjj" />
                </div>
                <div class="input-field date">
                    <label for="date_to" class="white">Tot:</label>
                    <input name="date_to" id="date_to" class="with-icon date" type="text" placeholder="dd-mm-jjjj" />
                </div>
                <div class="input-field accommodation">
                    <label for="vehicle" class="white">Soort verblijf:</label>
                    <select name="vehicle" id="vehicle">
                        <option value="">Maak een keuze</option>
                        <option value="chalet-6">4-persoons chalet</option>
                        <option value="chalet-6">6-persoons chalet</option>
                    </select>
                </div>
                <div class="input-field submit">
                    <a class="button blue" href="/boeken" title="Zoeken naar accommodaties">Zoeken <i class="icon-chevron-right"></i></a>
                </div>
            </form>
        </div>
    </div>
</section>
