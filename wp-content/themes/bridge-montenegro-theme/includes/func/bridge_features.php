<?php
// Configures positions for custom nav-menus and add theme supports
function bridge_features() {
    register_nav_menu('footer_location_1', 'Footer Location One');
    register_nav_menu('footer_location_2', 'Footer Location Two');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('leader_landscape', 400, 260, true);
    add_image_size('leader_portrait', 480, 650, true);
    add_image_size('page_banner', 1500, 350, true);
    add_image_size('slide', 1900, 525, true);
    
}