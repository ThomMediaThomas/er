<?php /* Template Name: Find-accommodation-page */ ?>

<?php get_header(); ?>

	<main role="main">
		<?php get_template_part('/elements/hero'); ?>
		<section class="section" id="accommodation-finder">
			<div class="content-wrapper">
				<div class="column-holder">
                    <div class="column aside">
                        <?php get_template_part('/elements/accommodation-finder/filters'); ?>
                    </div>
                    <div class="column main">
                        <div class="content-wrapper">
							<?php the_Field('above_search_results'); ?>
							<hr />
                            <?php
                            $meta_query = array('relation' => 'AND');

                            if (isset($_GET['stay_type'])) {
                                $meta_query[] = array(
                                    'key'	 	=> 'type',
                                    'value'	  	=> $_GET['stay_type'],
                                    'compare' 	=> 'LIKE',
                                );


								if ($_GET['stay_type'] == 'chalet' && isset($_GET['accommodation_type'])) {
									$meta_query[] = array(
										'key'	 	=> 'subtype',
										'value'	  	=> $_GET['accommodation_type'],
										'compare' 	=> 'LIKE',
									);
								}

								if ($_GET['stay_type'] == 'camping' && isset($_GET['vehicle'])) {
									$meta_query[] = array(
										'key'	 	=> 'subtype',
										'value'	  	=> $_GET['vehicle'],
										'compare' 	=> 'LIKE',
									);
								}
                            }

                            if (isset($_GET['adults']) || isset($_GET['children'])) {
                                $count = intval($_GET['adults']) + intval($_GET['children']);
                                $meta_query[] = array(
                                    'key'	 	=> 'max_guests',
                                    'value'	  	=> $count,
                                    'compare' 	=> '>=',
                                    'type'      => 'NUMERIC'
                                );
                            }

                            query_posts(array(
                                'post_type' => array('accommodation'),
                                'meta_query'	=> $meta_query
                            ));
                            ?>

                            <?php if (have_posts()) : while ( have_posts() ) : the_post(); ?>
                                <?php get_template_part('/elements/accommodation-finder/accommodation-preview'); ?>
                            <?php endwhile; endif; ?>
                        </div>
                    </div>
		        </div>
			</div>
		</section>
	</main>

<?php get_footer(); ?>
