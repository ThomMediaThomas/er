<h2 class="blue">Jouw gezelschap</h2>
<div class="family">
    <div class="input-field">
        <?php $adults = isset($_GET['adults']) ? $_GET['adults'] : null; ?>
        <label for="adults">Volwassenen:</label>
        <div class="counter">
            <span class="number-input">
                <span class="input-with-icon">
                    <i class="adults"></i>
                    <input name="adults" id="adults" type="number" placeholder="0" value="<?php echo $adults; ?>">
                </span>
                <i class="up">+</i>
                <i class="down">-</i>
            </span>
        </div>
    </div>
    <div class="input-field">
        <?php $children = isset($_GET['children']) ? $_GET['children'] : null; ?>
        <label for="children">Kinderen (4 t/m 15 jaar):</label>
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
        <label for="babies">Kinderen (0 t/m 3 jaar):</label>
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
        <label for="pets">Huisdieren:</label>
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
