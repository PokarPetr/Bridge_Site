<?php
/* Запрос к google картам для отображения мест, определение файлов со стилями сайта
*/
function bridge_files() {    
    wp_enqueue_style('bridge_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('bridge_extra_styles', get_theme_file_uri('/build/index.css'));
    
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:400i,700i|Roboto:400i,700i|Golos+Text:300,500,700');

    wp_enqueue_script('google-map', '//maps.googleapis.com/maps/api/js?key=AIzaSyCFJUtQIV89Wq1V8g004V-4eHsFk90-2uY', NULL, '1.0', true);
    wp_enqueue_script('main-bridge-script', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    // получаем начальный путь для Рест АПИ и одноразовый номер сессии
    wp_localize_script( 'main-bridge-script', 'bridge_data', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}