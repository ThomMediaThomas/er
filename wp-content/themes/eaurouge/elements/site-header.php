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
    <a id="show-nav" href="#" class="show-nav button yellow show-on-mobile"><i class="icon-menu"></i></a>
    <nav id="nav">
        <div class="content-wrapper">
            <?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
        </div>
        <a id="hide-nav" href="#" class="show-nav button yellow show-on-mobile"><i class="icon-close"></i></a>
    </nav>
</header>
