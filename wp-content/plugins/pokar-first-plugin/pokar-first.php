<?php
/*
    Plugin Name: Pokar Test Plugin
    Description: Плагин считает в постах количество слов, символов и время на прочтение. 
    Version: 1.0
    Author: Petr Pokar
    Author URI: https://github.com/PokarPetr/Application-Data-Analysis
    Text Domain: wcpdomain
    Domain Path: /languages
*/
/*
    Плагин позволяет организовать в дашборде: 
    - выбор где разместить информацию об количестве слов, символов и времени прочтения 
    - Заголовок блока с этой информацией
    - с помощью 3 checkbox выбрать какую информацию вывести
*/  

class WordCountAndTimePlugin {
    function __construct() {
        add_action('admin_menu', array($this, 'admin_page'));
        add_action('admin_init', array($this, 'settings'));
        add_filter('the_content', array($this, 'if_wrap'));
        add_action('init', array($this,'languages'));
        add_filter('acf/load_value', array($this, 'add_to_custom_content'), 10, 3);
    }

    function admin_page() {
        add_options_page('Word Count Settings', __('Word Count', 'wcpdomain'),'manage_options', 'word-count-settings-page', array($this, 'our_HTML'));
    }
    
    function settings() {
        add_settings_section( 'wcp_first_section', null, null, 'word-count-settings-page');
        
        //Две регистрационные функции для Display Location опции
        add_settings_field( 'wcp_location', 'Display Location', array($this, 'location_HTML'), 'word-count-settings-page', 'wcp_first_section');
        register_setting( 'wordcountplugin', 'wcp_location', array('sanitize_callback' => array($this, 'sanitize_location'), 'default' => '0'));
        
        //Две регистрационные функции для Headline Text опции
        add_settings_field( 'wcp_headline', 'Headline Text', array($this, 'headline_HTML'), 'word-count-settings-page', 'wcp_first_section');
        register_setting( 'wordcountplugin', 'wcp_headline', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'Post Statistics'));
        
        //Две регистрационные функции для Word Count опции
        add_settings_field( 'wcp_wordcount', 'Word Count', array($this, 'checkbox_HTML'), 'word-count-settings-page', 'wcp_first_section', array('the_name' => 'wcp_wordcount'));
        register_setting( 'wordcountplugin', 'wcp_wordcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
        
        //Две регистрационные функции для Character Count опции
        add_settings_field( 'wcp_charcount', 'Character Count', array($this, 'checkbox_HTML'), 'word-count-settings-page', 'wcp_first_section', array('the_name' => 'wcp_charcount'));
        register_setting( 'wordcountplugin', 'wcp_charcount', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
        
        //Две регистрационные функции для Read Time опции
        add_settings_field( 'wcp_readtime', 'Read Time', array($this, 'checkbox_HTML'), 'word-count-settings-page', 'wcp_first_section', array('the_name' => 'wcp_readtime'));
        register_setting( 'wordcountplugin', 'wcp_readtime', array('sanitize_callback' => 'sanitize_text_field', 'default' => '1'));
    }    


    // Проверяем является ли тип постом и выбран ли хотя бы один Checkbox
    function if_wrap($content) {
        if (is_main_query() AND is_single() AND (get_option('wcp_wordcount', '1') OR get_option('wcp_charcount', '1') OR get_option('wcp_readtime', '1'))) {
            return $this->create_HTML($content);
        }
        return $content;
    }
   
    // Добавляем контент к посту
    function create_HTML($content) {
        $html = '<p style="margin: 0; font-family: Montserrat; font-size: 32px;">' . esc_html(get_option('wcp_headline', 'Post Statistic')) . '</p><p style="font-family: Montserrat">';

        if ( get_option('wcp_wordcount', '1') OR get_option('wcp_readtime', '1')) {
            $wordcount = str_word_count(strip_tags($content));
        }
        if (get_option('wcp_wordcount', '0') == 1 AND $wordcount) {
            $html .= esc_html__('This post has', 'wcpdomain'). ' ' . $wordcount . ' ' . esc_html__('words', 'wcpdomain') . ';<br>';
        }       
        if (get_option('wcp_charcount', '1')) {
            $html .= 'Amount of characters is '. strlen(strip_tags($content)) . '; <br>';
        }
        if (get_option('wcp_readtime', '1')) {
            if ($wordcount) {
                $html .= 'This post will take about '. ceil($wordcount/225) . ' minute(s) to read;<br>';
            } else {
                $html .= 'This post will take about '. ceil(strlen(strip_tags($content))/1100) . ' minute(s) to read;<br>';
            }
            
        }
        $html .= '</p>';

        if (get_option('wcp_location', '0') == '0') {
            return $html . $content;
        }
        return $content . $html;
    }

     /* Для типа поста = play контент берем из кастомного поля 'main_body_content'
    поэтому логика немного сложнее    
    */
    function add_to_custom_content($main_body_content, $post_id, $field) {
        // Проверяем, является ли пост типом 'play' и полем 'main_body_content'
        if ($field['name'] === 'main_body_content' && get_post_type($post_id) === 'play' AND (get_option('wcp_wordcount', '1') OR get_option('wcp_charcount', '1') OR get_option('wcp_readtime', '1'))) {
            
            return $this->create_HTML($main_body_content);
        }
        return $main_body_content;
    }

    
    // Блок функций для каждой опции 
    // Функция для Display Location
    function location_HTML() { ?>
        <select name="wcp_location">
            <option value="0" <?php selected(get_option('wcp_location'), '0'); ?>>Beginning of post</option>
            <option value="1" <?php selected(get_option('wcp_location'), '1'); ?>>End of post</option>
        </select>
    <?php }
    // Функция для Headline Text
    function headline_HTML() { ?>
        <input  type="text" name="wcp_headline" value="<?php echo esc_attr(get_option('wcp_headline')); ?>">
    <?php }

    // Общая функция для трёх Checkboxes
    function checkbox_HTML($args) { ?>
        <input type="checkbox" name="<?php echo $args['the_name'] ?>" value="1" <?php checked(get_option($args['the_name']), '1') ?>>
    <?php }


    // Функция представление экрана и расположения опций на нём.
    function our_HTML() { ?>
        <div class="wrap">
            <h1 style="font-size: 250%; font-weight: 500;">Word Count Settings</h1>
            <form action="options.php" method="POST" >
                <?php 
                settings_fields('wordcountplugin');
                do_settings_sections( 'word-count-settings-page' );
                submit_button( );
                ?>
            </form>
            
        </div>
    <?php }

    
    // Функции для защиты от вредного ввода в выпадающем списке
    function sanitize_location($input) {
        if ($input != '0' AND $input != '1') {
            add_settings_error('wcp_location','wcp_location_error','Display Location must be either Beginning of post or End of post.');
            return get_option('wcp_location');
        }
        return $input;
        }

    // Функция для организации перевода
    function languages() {
        load_plugin_textdomain( 'wcpdomain', false, dirname(plugin_basename( __FILE__ )). '/languages');
    }    
}

$word_count_and_time_plugin = new WordCountAndTimePlugin();






























/*
add_filter('the_content', 'add_latest_line_to_content');

function add_latest_line_to_content($content) {
    if (is_page() && is_main_query()) {
        return $content . '<p>My name is Petr</p>';
    } else {
        return $content;
    }
}
*/