<?php the_field('extras_intro'); ?>
<?php $selected_extras = $_GET['extras']; ?>
<?php if(have_rows('extras', $_GET['accommodation_id'])): ?>
<?php while( have_rows('extras', $_GET['accommodation_id']) ): the_row(); ?>
    <div class="input-field">
            <?php
                $key = get_sub_field('key');
                $selected = $selected_extras ? in_array($key, $selected_extras) : false;
            ?>
            <label for="<?php echo $key; ?>" class="checkbox">
            <input type="checkbox" <?php if($selected): ?>checked="checked"<?php endif; ?> class="extras-for-stay" name="extras[]" value="<?php echo $key; ?>" id="<?php echo $key; ?>" />
            <span class="check"></span>
            <?php $per_night = get_sub_field('price_is_per_night'); ?>
            <?php the_sub_field('title'); ?> (+ € <?php echo number_format(get_sub_field('price'), 2); ?> <?php if ($per_night): ?>per nacht<?php else: ?>per verblijf<?php endif; ?>)
            <span class="checkbox-info">(<?php the_sub_field('info'); ?> )</span></label>
    </div>
<?php endwhile; ?>
<?php else: ?>
    <p><strong><?php the_field('no_extras_for_accommodation'); ?></strong></p>
<?php endif; ?>
