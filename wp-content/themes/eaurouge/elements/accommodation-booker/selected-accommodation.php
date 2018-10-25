<?php the_field('stay_intro'); ?>
<div class="box turqoise">
    <input type="hidden" id="accommodation_id" name="accommodation_id" value="<?php echo $_GET['accommodation_id']; ?>"/>
    <?php if (isset($_GET['accommodation_id'])) : ?>
    <div class="content-wrapper">
        <?php
        global $post;
        $post = get_post($_GET['accommodation_id']);
        setup_postdata( $post );
        get_template_part('/elements/accommodation-finder/accommodation-preview-simple');
        wp_reset_postdata();
        ?>
    </div>
    <?php endif; ?>
</div>
