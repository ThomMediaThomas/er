<?php if (have_rows('reviews')): ?>
    <section class="section reviews">
        <div class="content-wrapper">
            <div class="slider">
                <div class="slides">
                    <?php while (have_rows('reviews')): the_row(); ?>
                        <div class="slide">
                            <div class="review">
                                <?php $rating = (float)get_sub_field('rating'); ?>
                                <p class="quote"><?php the_sub_field('quote'); ?></p>
                                <span class="rating-holder">
                                    <span class="rating" style="width: <?php echo ($rating / 5) * 100; ?>%;"></span>
                                </span>
                                <strong class="author"><?php the_sub_field('author'); ?>
                                    <span>- <?php the_sub_field('date'); ?></span></strong>
                                <span class="source">bron: <?php the_sub_field('source'); ?></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
                <a href="#" class="slide-nav previous"><i class="icon-chevron-left"></i></a>
                <a href="#" class="slide-nav next"><i class="icon-chevron-right"></i></a>
            </div>
        </div>
    </section>
<?php endif; ?>
