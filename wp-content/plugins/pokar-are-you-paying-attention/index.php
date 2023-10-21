<?php
/*
    Plugin Name: Are You Paying Attention Quiz
    Description: Give your readers a multiple choice question.
    Version: 1.0
    Author: Petr Pokar
    Author URI: https://github.com/PokarPetr/Application-Data-Analysis
    
*/
if ( ! defined( 'ABSPATH')) exit; //Exit if accessed directly

class AreYouPayingAttention {
    function __construct() {
        // Перехватываем кук при загрузке блоков
        add_action('enqueue_block_editor_assets', array($this, 'admin_assets'));
        
    }
    /* Организуем загрузку нашего JavaScript файла
        wp_enqueue_script(1, 2, 3);
        1 короткое имя, чтобы Wordpress мог его идентифицировать
        2 URL к нашему файлу
        3 список зависимостей, то что нужно подгрузить для работы скрипта
    */
    function admin_assets() {
        wp_enqueue_script('our_new_block_type', plugin_dir_url(__FILE__) . 'test.js', array('wp-blocks', 'wp-element'));
    }
}

$areYouPayingAttention = new AreYouPayingAttention();