<?php
    $title = get_the_title();
?>
<div class="accommodation-preview simple">
    <div class="left">
        <img class="image-larger" src="<?php echo get_the_post_thumbnail_url(); ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" />
    </div>
    <div class="right">
        <h3 class="red no-margin"><?php the_title(); ?></h3>
        <h4 class=""><?php the_field('subtitle'); ?></h4>
        <ul class="usps small">
            <?php while( have_rows('usps') ): the_row(); ?>
                <li><i class="icon-check"></i><?php the_sub_field('usp'); ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>
