<?php
/* Блок функций который описывает кастомные типы 
(события, локации, игроки, игры, описания правил игры и правил торговли, записи )
- массив labels отвечает за отображение в дашборде,
- если 'show_in_rest' => true то посты будут отображаться в REST API JSON
-'capability_type' => 'note' и 'map_meta_cap' => true для создания различных разрешений для разных ролей
- public => false закрывает тип от поиска(записки), а также выкидывает из дашборда, 
поэтому добавляют show_ui => true.

*/

function bridge_post_types() {
    // Event post type
    register_post_type('event', array(
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'events'),
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Events',
            'add_new_item' => "Add New Event",
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ),
        'menu_icon'=> 'dashicons-calendar'       
    ));

    // Location post type
    register_post_type('location', array(
        'supports' => array('title', 'editor', 'excerpt'),
        'rewrite' => array('slug' => 'locations'),
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Locations',
            'add_new_item' => "Add New Location",
            'edit_item' => 'Edit Location',
            'all_items' => 'All Locations',
            'singular_name' => 'Location'
        ),
        'menu_icon'=> 'dashicons-location-alt'       
    ));
    
    // Plays post type
    register_post_type('play', array(
        'supports' => array('title'),
        'rewrite' => array('slug' => 'plays'),
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Plays',
            'add_new_item' => "Add New Play",
            'edit_item' => 'Edit Play',
            'all_items' => 'All Plays',
            'singular_name' => 'Play'
        ),
        'menu_icon'=> 'dashicons-awards'       
    ));

     // Bidding Etiquette post type
     register_post_type('etiquette', array(
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'etiquette'),
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Etiquettes',
            'add_new_item' => "Add New Etiquette",
            'edit_item' => 'Edit Etiquette',
            'all_items' => 'All Etiquettes',
            'singular_name' => 'Etiquette'
        ),
        'menu_icon'=> 'dashicons-universal-access'       
    ));

     // Card rules post type
     register_post_type('rule', array(
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'rules'),
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Rules',
            'add_new_item' => "Add New Rule",
            'edit_item' => 'Edit Rule',
            'all_items' => 'All Rules',
            'singular_name' => 'Rule'
        ),
        'menu_icon'=> 'dashicons-media-document'       
    ));

    // Leaders post type
    register_post_type('leader', array(
        'supports' => array('title', 'editor', 'thumbnail' ),        
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => 'Leaders',
            'add_new_item' => "Add New Leader",
            'edit_item' => 'Edit Leader',
            'all_items' => 'All Leaders',
            'singular_name' => 'Leader'
        ),
        'menu_icon'=> 'dashicons-welcome-learn-more'       
    ));
    // My Notes post type
    register_post_type('note', array(
        'capability_type' => 'note',
        'map_meta_cap' => true,   
        'show_in_rest' => true,     
        'supports' => array('title', 'editor'),        
        'public' => false,
        'show_ui' => true,        
        'labels' => array(
            'name' => 'Notes',
            'add_new_item' => "Add New Note",
            'edit_item' => 'Edit Note',
            'all_items' => 'All Notes',
            'singular_name' => 'Note'
        ),
        'menu_icon'=> 'dashicons-welcome-write-blog'       
    ));

    // Like Post Type
    register_post_type('like', array(
    'supports' => array('title'),
    'public' => false,
    'show_ui' => true,
    'labels' => array(
      'name' => 'Likes',
      'add_new_item' => 'Add New Like',
      'edit_item' => 'Edit Like',
      'all_items' => 'All Likes',
      'singular_name' => 'Like'
    ),
    'menu_icon' => 'dashicons-heart'
  ));

   // Hero slide post type
     register_post_type('slide', array(
        'supports' => array('title', 'editor'),
        'rewrite' => array('slug' => 'slides'),
        'has_archive' => false,
        'public' => true,
        'show_in_rest' => false,
        'labels' => array(
            'name' => 'Slides',
            'add_new_item' => "Add New Slide",
            'edit_item' => 'Edit Slide',
            'all_items' => 'All Slides',
            'singular_name' => 'Slide'
        ),
        'menu_icon'=> 'dashicons-welcome-view-site'       
    ));
}
add_action('init', 'bridge_post_types');

