<section class="hero" style="background-image: url('<?php echo get_field('image'); ?>;">
    <div class="content-wrapper">
        <?php if (get_field('show_logo')) : ?>
            <a href="/" title="Camping de l'eau rouge" class="logo-holder">
                <img class="logo small" src="<?php echo get_template_directory_uri(); ?>/img/logo.png" title="Domaine de l'eau rouge" alt="Domaine de l'eau rouge" />
            </a>
        <?php endif; ?>
        <h1 class="<?php echo get_field('title_color'); ?>"><?php echo get_field('title'); ?></h1>
        <h2 class="<?php echo get_field('subtitle_color'); ?>"><?php echo get_field('subtitle'); ?></h2>
    </div>
</section>
