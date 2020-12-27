<?php the_field('family_details_intro', 'options'); ?>
<div class="family-members">
    <div class="family-member" id="family-member-you">
        <div class="input-field">
            <label for="your_name"><?php _e('Naam en voornaam van hoofdboeker', 'eaurouge'); ?> *:</label>
            <span class="input-with-icon">
                <i class="user"></i>
                <input name="your_name" id="your_name" class="family-member-name required prevent-reload-small-parts" autocomplete="off" type="text" />
            </span>
        </div>
    </div>
    <div id="family-holder">
        <div id="family-member-template">
            <div class="family-member">
                <div class="input-field">
                    <label for="member_MEMBER_COUNT_name"><?php _e('Naam en voornaam van reisgenoot', 'eaurouge'); ?> MEMBER_COUNT *:</label>
                    <span class="input-with-icon">
                        <i class="user"></i>
                        <input name="member_MEMBER_COUNT_name" id="member_MEMBER_COUNT_name" class="family-member-name required prevent-reload-small-parts" autocomplete="off" type="text" />
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
