<?php if( have_rows('blocks') ): ?>
    <?php while( have_rows('blocks') ): the_row();
        $block_type = get_sub_field('block_type');
        $intro = get_sub_field('intro');
        ?>
        <section class="section">
            <?php if( have_rows('sub_blocks') ): ?>
                <?php if ($block_type == 'double-half'): ?>
                    <?php while( have_rows('sub_blocks') ): the_row();
                        $sub_block_type = get_sub_field('sub_block_type');
                        $color = get_sub_field('color');
                        ?>
                            <?php if ($sub_block_type == 'image'): ?>
                                <div class="block <?php echo $sub_block_type . ' ' . $color; ?>" style="background-image: url('<?php echo get_sub_field('image'); ?>')">
                                    <img src="<?php echo get_sub_field('image'); ?>" />
                                </div>
                            <?php endif; ?>
                            <?php if ($sub_block_type == 'text'): ?>
                                <div class="block <?php echo $sub_block_type . ' ' . $color; ?>">
                                    <div class="content-wrapper">
                                        <?php echo get_sub_field('text'); ?>
                                        <?php get_template_part('/elements/buttons'); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php if ($block_type == 'with-aside'): ?>
                    <div class="content-wrapper">
                        <div class="column-holder">
                            <?php while( have_rows('sub_blocks') ): the_row();
                                $sub_block_type = get_sub_field('sub_block_type');
                                $color = get_sub_field('color'); ?>
                                <div class="column <?php echo get_row_index() == 1 ? 'main' : 'aside'; ?>">
                                    <?php if ($sub_block_type == 'image'): ?>
                                        <img src="<?php echo get_sub_field('image'); ?>" />
                                    <?php endif; ?>
                                    <?php if ($sub_block_type == 'text'): ?>
                                        <?php if(get_row_index() != 1): ?>
                                            <div class="box <?php echo get_sub_field('color'); ?>">
                                        <?php endif; ?>
                                            <div class="content-wrapper">
                                                <?php echo get_sub_field('text'); ?>
                                                <?php get_template_part('/elements/buttons'); ?>
                                            </div>
                                        <?php if(get_row_index() != 1): ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($block_type == 'three-panes'): ?>
                    <div class="content-wrapper">
                        <div class="section-intro">
                            <?php echo $intro; ?>
                        </div>
                        <div class="column-holder">
                            <?php while( have_rows('sub_blocks') ): the_row();
                                $sub_block_type = get_sub_field('sub_block_type');
                                $color = get_sub_field('color'); ?>
                                <div class="column third">
                                    <div class="content-wrapper">
                                        <div class="box <?php echo $color; ?>">
                                            <img src="<?php echo get_sub_field('image'); ?>" />
                                            <div class="content-wrapper">
                                                <?php echo get_sub_field('text'); ?>
                                                <?php get_template_part('/elements/buttons'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </section>
    <?php endwhile; ?>
<?php endif; ?>
