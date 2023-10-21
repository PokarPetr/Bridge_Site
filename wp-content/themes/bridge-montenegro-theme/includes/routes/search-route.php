<?php

add_action('rest_api_init', 'bridge_register_search' );

function bridge_register_search() {
register_rest_route('bridge/v1', 'search', array(
    'methods' => WP_REST_SERVER::READABLE, //Just the same as GET
    'callback' => 'bridge_search_results'
));
}

function bridge_search_results($data) {
    /* Где будем искать? посмотри в post_type   
     А что, посмотри в 's'
    */ 
    $main_query = new WP_Query(array(
        'post_type' => array('post', 'page', 'event', 'leader', 'rule', 'etiquette', 'location', 'play'),
        's' => sanitize_text_field($data['term'])
    ));
    // Здесь будем хранить результаты поиска, пока всё пустое)))
    $results = array(
        'general_info' => array(),
        'leader' => array(),
        'play' => array(),
        'rule' => array(),
        'event' => array(),        
        'location' => array(),
    );

    /* Побежали по главному запросу и 
    для каждого отдельного вида постов собираем результаты. 
    Дальше на странице результаты будут выводиться в трех разных колонках,
    в своих разделах.
    */
    while($main_query->have_posts()) {
        $main_query->the_post();
        // Здесь формируем ответ для постов и страниц
        if (get_post_type() == 'post' | get_post_type() == 'page') {
        array_push($results['general_info'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'post_type' => get_post_type(),
            'author_name' => get_the_author(),
        ));
        }
        // Здесь для раздела Игры
        if (get_post_type() == 'play') {
            $related_location = get_field('related_location');
            if ($related_location) {
                foreach($related_location as $loc) {
                    array_push($results['location'], array(
                        'title' => get_the_title($loc),
                        'permalink' => get_the_permalink($loc)
                    ));
                }
            }
            array_push($results['play'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'id' => get_the_ID(),
        ));
        }
        // Здесь для разделов Правила и Правила Торговли
        if (get_post_type() == 'rule' | get_post_type() == 'etiquette') {
            array_push($results['rule'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'id' => get_the_ID(),
            ));
        }
        // Здесь для раздела События
        if (get_post_type() == 'event') {
        $event_date = get_field('event_date');
        $date = DateTime::createFromFormat('d/m/Y', $event_date);

        $description = null;
        if (has_excerpt()) {
            $description = get_the_excerpt();
        } else {
        $description = wp_trim_words( get_the_content(), 18);
        }

        array_push($results['event'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'month' => $date->format('M'),
            'day' => $date->format('d'),
            'description' => $description,
        ));
        }

        // Здесь для раздела Места встреч
        if (get_post_type() == 'location') {
        array_push($results['location'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
        ));
        }
        if (get_post_type() == 'leader') {
        array_push($results['leader'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'image' => get_the_post_thumbnail_url(0, 'leader_landscape'),
        ));
        }    
    }

    if($results['leader']) {
        $play_met_query = array('relation' => 'OR');

        foreach($results['play'] as $item) {
        array_push($play_met_query, array(
            'key' => 'related_play',
            'compare' => 'LIKE',
            'value' => '"' . $item['id'] . '"'
        ));
        }
        $leader_relationship_query = new WP_Query(array(
            'post_type' => array('leader', 'event'),      
            'meta_query' => $play_met_query
        ));
        while($leader_relationship_query->have_posts()) {
            $leader_relationship_query->the_post();
            if (get_post_type() == 'leader') {
                array_push($results['leader'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(0, 'leader_landscape'),
                ));
            }
            if (get_post_type() == 'event') {
                $event_date = get_field('event_date');
                $date = DateTime::createFromFormat('d/m/Y', $event_date);
    
                $description = null;
                if (has_excerpt()) {
                    $description = get_the_excerpt();
                } else {
                $description = wp_trim_words( get_the_content(), 18);
                }
    
                array_push($results['event'], array(
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'month' => $date->format('M'),
                    'day' => $date->format('d'),
                    'description' => $description,
                ));
            }
        }

// Убераем возможные повторение в поиске, чтобы отображать в окне только по одному разу, иначе будет длинная череда одинаковых ссылок друг за другом  
$results['leader'] = array_values(array_unique($results['leader'], SORT_REGULAR));
$results['event'] = array_values(array_unique($results['event'], SORT_REGULAR));
$results['location'] = array_values(array_unique($results['location'], SORT_REGULAR));
}

// Возвращаем результат поиска
return  $results;
}


