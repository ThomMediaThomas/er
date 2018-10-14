<?php $title = get_the_title(); ?>
<div class="accommodation-preview">
    <div class="left">
        <img class="image-larger" src="<?php echo get_the_post_thumbnail_url(); ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" />
        <ul class="images">
            <li>
                <a href="<?php echo get_the_post_thumbnail_url(); ?>" class="set-image active" title="<?php echo $title; ?>">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" />
                </a>
            </li>
            <?php while( have_rows('images') ): the_row(); ?>
                <li>
                    <a href="<?php the_sub_field('image'); ?>" class="set-image" title="<?php echo $title; ?>">
                        <img src="<?php the_sub_field('image'); ?>" title="<?php echo $title; ?>" alt="<?php echo $title; ?>" />
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>

    </div>
    <div class="right">
        <h3 class="red no-margin"><?php the_title(); ?></h3>
        <h4 class=""><?php the_field('subtitle'); ?></h4>
        <ul class="usps small">
            <?php while( have_rows('usps') ): the_row(); ?>
                <li><i class="icon-check"></i><?php the_sub_field('usp'); ?></li>
            <?php endwhile; ?>
        </ul>
        <div class="bottom">
            <div class="bottom-left">
                <span>Prijzen vanaf: </span>
                <strong>25 €</strong>
                <span>per nacht</span>
            </div>
            <a class="button yellow small">Verblijf boeken<i class="icon-chevron-right"></i></a>
        </div>
    </div>
</div>
