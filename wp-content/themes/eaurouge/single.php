<?php get_header(); ?>

<main role="main">

    <?php get_template_part('/elements/hero'); ?>

    <?php while (have_posts()) : the_post(); ?>
        <div class="section">
            <div class="content-wrapper">
                <div class="column-holder">
                    <div class="column single-narrowed">
                        <?php echo the_content(); ?>
                        <hr />
                        <p>
                        <?php
                        $categories = get_the_category();
                        if ($categories) {
                            foreach($categories as $category) {
                                echo '<span class="tag category">' . $category->name . '</span>';
                            }
                        }

                        $tags = get_the_tags();
                        if ($tags) {
                            foreach($tags as $tag) {
                                echo '<span class="tag">' . $tag->name . '</span>';
                            }
                        }
                        ?>
                        </p>
                        <p class="note">geplaatst op <strong><?php the_time('d-m-Y') ?></strong> door <strong><?php the_author() ?></strong></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
