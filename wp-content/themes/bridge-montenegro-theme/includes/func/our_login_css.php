<?php
//Добавление стилей на страницу ввода пароля

function our_login_CSS() {
    wp_enqueue_style('bridge_main_styles', get_theme_file_uri('/build/style-index.css'));
    wp_enqueue_style('bridge_extra_styles', get_theme_file_uri('/build/index.css'));
    
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('custom-google-font', '//fonts.googleapis.com/css?family=Roboto+Condensed:400i,700i|Roboto:400i,700i|Golos+Text:300,500,700');
}