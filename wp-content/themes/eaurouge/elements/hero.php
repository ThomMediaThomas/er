<section class="hero">
    <div class="slider" data-auto="true">
        <div class="slides">
            <div class="slide" style="background-image: url('<?php echo get_field('image'); ?>');"></div>
            <?php if (have_rows('more_images')): ?>
                <?php while (have_rows('more_images')): the_row(); ?>
                    <div class="slide" style="background-image: url('<?php echo get_sub_field('image'); ?>');"></div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
        <a href="#" class="slide-nav previous"><i class="icon-chevron-left"></i></a>
        <a href="#" class="slide-nav next"><i class="icon-chevron-right"></i></a>
    </div>
    <div class="content-wrapper">
        <?php if (get_field('show_logo')) : ?>
            <a href="/" title="Camping de l'Eau Rouge" class="logo-holder">
                <img class="logo small" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" title="Domaine de l'Eau Rouge" alt="Domaine de l'Eau Rouge" />
            </a>
        <?php endif; ?>
        <h1 class="<?php echo get_field('title_color'); ?>"><?php echo get_field('title'); ?></h1>
        <h2 class="<?php echo get_field('subtitle_color'); ?>"><?php echo get_field('subtitle'); ?></h2>
    </div>
</section>
<?php if (get_field('show_quick_booker')) : ?>
    <?php get_template_part('/elements/quick-booking'); ?>
<?php endif; ?>
<?php get_template_part('/elements/breadcrumbs'); ?>
