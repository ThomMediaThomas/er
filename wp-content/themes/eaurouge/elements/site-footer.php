<div id="labels">
    <div class="inner">
        <div class="content-wrapper">
            <div class="left">
                <?php if(have_rows('links_left', 'options')): ?>
                    <?php while( have_rows('links_left', 'options') ): the_row(); ?>
                        <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>" target="_blank">
                            <img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('title'); ?>" title="<?php the_sub_field('title'); ?>" />
                        </a>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
            <div class="right">
                <?php if(have_rows('links_right', 'options')): ?>
                    <?php while( have_rows('links_right', 'options') ): the_row(); ?>
                        <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>" target="_blank">
                            <img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('title'); ?>" title="<?php the_sub_field('title'); ?>" />
                        </a>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<footer id="footer">
    <div class="content-wrapper">
        <div class="footer-block first">
            <h4 class="red"><?php the_field('contact_block_title', 'options'); ?></h4>
            <div class="footer-block-row">
                <div class="footer-block-column">
                    <?php the_field('contact_block_1', 'option'); ?>
                </div>
                <div class="footer-block-column">
                    <?php the_field('contact_block_2', 'option'); ?>
                </div>
            </div>
            <div class="footer-block-row">
                <h5 class="blue"><?php the_field('sitemap_block_title', 'options'); ?></h5>
                <div class="footer-block-column">
                    <?php the_field('sitemap_block_1', 'option'); ?>
                </div>
                <div class="footer-block-column">
                    <?php the_field('sitemap_block_2', 'option'); ?>
                </div>
            </div>
        </div>
        <div class="footer-block second">
            <h4 class="red"><?php the_field('rating_title', 'options'); ?></h4>
            <?php $rating = (float)get_field('rating', 'options'); ?>
            <span class="rating-holder white">
                <span class="rating" style="width: <?php echo ($rating/5)*100; ?>%;"></span>
            </span>
            <?php the_field('rating_text', 'options'); ?>
            <h4 class="red"><?php the_field('follow_block_title', 'options'); ?></h4>
            <?php if(have_rows('follow_block_mediums', 'options')): ?>
                <ul class="horizontal">
                    <?php while( have_rows('follow_block_mediums', 'options') ): the_row(); ?>
                        <li>
                            <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>" target="_blank">
                                <img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('title'); ?>" title="<?php the_sub_field('title'); ?>" />
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
            <h5 class="blue"><?php the_field('friends_title', 'options'); ?></h5>
            <?php if(have_rows('friends', 'options')): ?>
                <ul class="horizontal">
                    <?php while( have_rows('friends', 'options') ): the_row(); ?>
                        <li>
                            <a href="<?php the_sub_field('link'); ?>" title="<?php the_sub_field('title'); ?>" target="_blank">
                                <img src="<?php the_sub_field('image'); ?>" alt="<?php the_sub_field('title'); ?>" title="<?php the_sub_field('title'); ?>" />
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</footer>
<div id="bottom-bar">
    <div class="content-wrapper">
        Domaine de l'eau rouge - Cheneux 25 - 4970 Stavelot (België)
    </div>
</div>
