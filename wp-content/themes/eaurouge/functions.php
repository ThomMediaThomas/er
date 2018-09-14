<?php
function register_menus() {
    register_nav_menu('header-menu', __('Header Menu'));
}
add_action('init', 'register_menus');
