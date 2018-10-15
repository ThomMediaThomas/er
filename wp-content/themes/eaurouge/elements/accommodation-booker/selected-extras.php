<h2 class="blue">Extra's</h2>
<p>Vink hieronder de extra's aan waar je gebruik van wenst te maken tijdens je vakantie.</p>
<?php $selected_extras = $_GET['extras']; ?>
<?php while( have_rows('extras', $_GET['accommodation_id']) ): the_row(); ?>
    <div class="input-field">
            <?php
                $key = get_sub_field('key');
                $selected = in_array($key, $selected_extras);
            ?>
            <label for="<?php echo $key; ?>" class="checkbox">
            <input type="checkbox" <?php if($selected): ?>checked="checked"<?php endif; ?> class="extras-for-stay" name="<?php echo $key; ?>" id="<?php echo $key; ?>" />
            <span class="check"></span>
            <?php $per_night = get_sub_field('price_is_per_night'); ?>
            <?php the_sub_field('title'); ?> (+ € <?php echo number_format(get_sub_field('price'), 2); ?> <?php if ($per_night): ?>per nacht<?php else: ?>per verblijf<?php endif; ?>)
            <span class="checkbox-info">(<?php the_sub_field('info'); ?> )</span></label>
    </div>
<?php endwhile; ?>
