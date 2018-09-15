<?php if( have_rows('buttons') ): ?>
    <?php while( have_rows('buttons') ): the_row(); ?>
        <a class="button <?php echo get_sub_field('color'); ?> <?php if (get_sub_field('small')): ?>small<?php endif; ?>" href="<?php echo get_sub_field('link'); ?>"><?php echo get_sub_field('label'); ?> <i class="icon-chevron-right"></i></a>
    <?php endwhile; ?>
<?php endif; ?>
