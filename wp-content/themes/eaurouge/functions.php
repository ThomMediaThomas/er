<?php
function register_menus() {
    register_nav_menu('header-menu', __('Header Menu'));
}
add_action('init', 'register_menus');

if (function_exists('acf_add_options_page')) {
    acf_add_options_page();
}

add_theme_support('post-thumbnails');
add_post_type_support('post', 'excerpt');