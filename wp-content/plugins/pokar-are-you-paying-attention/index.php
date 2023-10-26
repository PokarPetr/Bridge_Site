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
        wp_register_style('quiz_edit_css', plugin_dir_url(__FILE__) . 'build/index.css');
        wp_enqueue_script('our_new_block_type', plugin_dir_url(__FILE__) . 'test.js', array('wp-blocks', 'wp-element'));
        register_block_type('ourplugin/are-you-paying-attention', array(
            'editor_script' => 'our_new_block_type',
            'editor_style' => 'quiz_edit_css',
            'render_callback' => array($this, 'the_HTML')
        ));
    }
     /*Функция отображения блока
        загружаем frontend.js и frontend.css только когда он нужен посту
        ob_start(); - начало буферизации вывода
        В теге <pre> получаем данные из базы данных поста с помощью функции wp_json_encode()
        ob_get_clean(); - возвращает содержимое буфера в виде строки
    */
    function the_HTML($attributes) { 
        // в массиве array('wp-element') wp-element - это PHP вариант React     
        if(!is_admin()) {
            wp_enqueue_script('attention_frontend', plugin_dir_url( __File__ ) . 'build/frontend.js', array('wp-element'));
            wp_enqueue_style('attention_frontend_styles', plugin_dir_url( __File__ ) . 'build/frontend.css');
        }

       ob_start(); ?>
        <div class="paying-attention-update-me"><pre style="display: none;"><?php echo wp_json_encode( $attributes ); ?></pre></div>
       <?php return ob_get_clean();
    }
}

$areYouPayingAttention = new AreYouPayingAttention();