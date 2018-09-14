<?php if( have_rows('buttons') ): ?>
    <?php while( have_rows('buttons') ): the_row(); ?>
        <a class="button <?php echo get_sub_field('color'); ?>"><?php echo get_sub_field('label'); ?> <i class="icon-chevron-right"></i></a>
    <?php endwhile; ?>
<?php endif; ?>
