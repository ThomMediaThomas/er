<div id="top-bar">
    <div class="content-wrapper">
        <div class="left">
            <?php the_field('left', 'option'); ?>
        </div>
        <div class="right">
            <?php the_field('right', 'option'); ?>
        </div>
    </div>
</div>
<header id="header">
    <nav id="nav">
        <div class="content-wrapper">
            <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
        </div>
    </nav>
</header>
