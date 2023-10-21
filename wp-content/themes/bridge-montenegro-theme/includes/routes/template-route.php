<?php

// add_action('rest_api_init', 'bridge_register_search' );

function bridge_register_search() {
register_rest_route('bridge/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE, //Just the same as GET
    'callback' => 'bridge_search_results'
));
}

function bridge_search_results($data) {
    
    $main_query = new WP_Query(array(
        'post_type' => array('post', 'page', 'event', 'leader'),
        's' => sanitize_text_field($data['term'])
    ));

    $results = array();

    while($main_query->have_posts()) {
        $main_query->the_post();
        array_push($results, array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
        ));
    }
    return  $results;
}
