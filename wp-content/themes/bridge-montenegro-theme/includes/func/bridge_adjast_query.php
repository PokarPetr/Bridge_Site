<?php
// Configures the basic query for different post types.

function bridge_adjast_query($query) {
    
    if ( !is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
     $today = date('Ymd');
     $query->set('meta_key', 'event_date');
     $query->set('orderby', 'meta_value_num');
     $query->set('order', 'ASC');
     $query->set('meta_query', array(
         array(
           'key' => 'event_date',
           'compare' => '>=',
           'value' => $today,
           'type' => 'numeric'
         )));
     }
 
     if ( !is_admin() AND is_post_type_archive('location') AND $query->is_main_query()) {         
         $query->set('posts_per_page', -1);
     }
 
     if ( !is_admin() AND is_post_type_archive('play') AND $query->is_main_query()) {         
         $query->set('orderby', 'title');
         $query->set('order', 'ASC');
         $query->set('posts_per_page', -1);
     }
     
 }