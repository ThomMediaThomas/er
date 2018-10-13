<?php /* Template Name: Find-accommodation-page */ ?>

<?php get_header(); ?>

	<main role="main">
		<?php get_template_part('/elements/hero'); ?>
		<section class="section" id="accommodation-finder">
			<div class="content-wrapper">
				<div class="column-holder">
                <div class="column aside">
                    <div class="box yellow">
                        <div class="content-wrapper">
                            <h3 class="red">Verblijf</h3>
                            <div class="input-field">
                                <?php $stayType = isset($_GET['stay_type']) ? $_GET['stay_type'] : null; ?>
                                <label for="stay_type" class="white">Type:</label>
                                <select name="stay_type" id="stay_type">
                                    <option value="">Maak een keuze</option>
                                    <option value="chalet" <?php if($stayType == 'chalet'): ?>selected="selected"<?php endif; ?>>Chalet</option>
                                    <option value="camping" <?php if($stayType == 'camping'): ?>selected="selected"<?php endif; ?>>Kampeerplaats</option>
                                </select>
                            </div>
                            <div class="input-field" id="stay_type_camping">
                                <?php $vehicle = isset($_GET['vehicle']) ? $_GET['vehicle'] : null; ?>
                                <label for="vehicle" class="white">Kampeermiddel:</label>
                                <select name="vehicle" id="vehicle">
                                    <option value="">Maak een keuze</option>
                                    <option value="tent" <?php if($vehicle == 'tent'): ?>selected="selected"<?php endif; ?>>Tent</option>
                                    <option value="caravan" <?php if($vehicle == 'caravan'): ?>selected="selected"<?php endif; ?>>Caravan</option>
                                    <option value="camper" <?php if($vehicle == 'camper'): ?>selected="selected"<?php endif; ?>>Camper</option>
                                    <option value="folding_car" <?php if($vehicle == 'folding_car'): ?>selected="selected"<?php endif; ?>>Vouwwagen</option>
                                    <option value="other" <?php if($vehicle == 'other'): ?>selected="selected"<?php endif; ?>>Anders</option>
                                </select>
                            </div>
                            <div class="input-field" id="stay_type_chalet">
                                <?php $accommodation = isset($_GET['accommodation']) ? $_GET['accommodation'] : null; ?>
                                <label for="accommodation" class="white">Soort verblijf:</label>
                                <select name="accommodation" id="accommodation">
                                    <option value="">Maak een keuze</option>
                                    <option value="chalet-4" <?php if($accommodation == 'chalet-4'): ?>selected="selected"<?php endif; ?>>4-persoons chalet</option>
                                    <option value="chalet-6" <?php if($accommodation == 'chalet-6'): ?>selected="selected"<?php endif; ?>>6-persoons chalet</option>
                                </select>
                            </div>
                            <div class="input-field">
                                <?php $stayDateFrom = isset($_GET['stay_date_from']) ? $_GET['stay_date_from'] : null; ?>
                                <label for="stay_date_from" class="white">Van:</label>
                                <span class="input-with-icon">
                                    <i class="date"></i>
                                    <input name="stay_date_from" value="<?php echo $stayDateFrom; ?>" class="datepicker" id="stay_date_from" type="text" placeholder="dd-mm-jjjj">
                                </span>
                            </div>
                            <div class="input-field">
                                <?php $stayDateTo = isset($_GET['stay_date_to']) ? $_GET['stay_date_to'] : null; ?>
                                <label for="stay_date_to" class="white">Tot:</label>
                                <span class="input-with-icon">
                                    <i class="date"></i>
                                    <input name="stay_date_to" value="<?php echo $stayDateTo; ?>" class="datepicker" id="stay_date_to" type="text" placeholder="dd-mm-jjjj" />
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="box turqoise">
                        <div class="content-wrapper">
                            <h3 class="blue">Reisgezelschap</h3>
                            <div class="input-field">
                                <?php $adults = isset($_GET['adults']) ? $_GET['adults'] : null; ?>
                                <label for="adults" class="white">Aantal volwassenen:</label>
                                <div class="counter">
                                    <span class="number-input">
                                        <span class="input-with-icon">
                                            <i class="adults"></i>
                                            <input name="adults" value="<?php echo $adults; ?>" id="adults" type="number" placeholder="0" />
                                        </span>
                                        <i class="up">+</i>
                                        <i class="down">-</i>
                                    </span>
                                </div>
                            </div>
                            <div class="input-field">
                                <?php $children = isset($_GET['children']) ? $_GET['children'] : null; ?>
                                <label for="children" class="white">Aantal kinderen:</label>
                                <div class="counter">
                                    <span class="number-input">
                                        <span class="input-with-icon">
                                            <i class="children"></i>
                                            <input name="children" value="<?php echo $children; ?>" id="children" type="number" placeholder="0" />
                                        </span>
                                        <i class="up">+</i>
                                        <i class="down">-</i>
                                    </span>
                                </div>
                            </div>
                            <div class="input-field">
                                <?php $pets = isset($_GET['pets']) ? $_GET['pets'] : null; ?>
                                <label for="pets" class="white">Aantal huisdieren:</label>
                                <div class="counter">
                                    <span class="number-input">
                                        <span class="input-with-icon">
                                            <i class="pets"></i>
                                            <input name="pets" value="<?php echo $pets; ?>" id="pets" type="number" placeholder="0" />
                                        </span>
                                        <i class="up">+</i>
                                        <i class="down">-</i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column main">
                    <div class="content-wrapper">
                        <?php
                        $meta_query = array('relation'		=> 'AND');

                        if (isset($_GET['stay_type'])) {
                            $meta_query[] = array(
                                'key'	 	=> 'type',
                                'value'	  	=> $_GET['stay_type'],
                                'compare' 	=> 'LIKE',
                            );
                        }

                        query_posts(array(
                            'post_type' => array('accommodation'),
                            'meta_query'	=> $meta_query
                        ));

                        if (have_posts()) : while ( have_posts() ) : the_post();
                            $title = get_the_title();
                            ?>
                            <div class="accommodation">
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
                            <?php
                        endwhile;
                        endif;
                        ?>
                    </div>
                </div>
		</div>
			</div>
		</section>
	</main>

<?php get_footer(); ?>
