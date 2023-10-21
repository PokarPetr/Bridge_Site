<?php
/*
    Plugin Name: Pokar Word Filter Plugin
    Description: Replaces a list of words    .
    Version: 1.0
    Author: Petr Pokar
    Author URI: https://github.com/PokarPetr/Application-Data-Analysis
    
*/
if ( ! defined( 'ABSPATH')) exit; //Exit if accessed directly

class PokarWordFilterPlugin {
    function __construct() {
        add_action( 'admin_menu', array($this, 'our_menu'));
        add_action( 'admin_init', array($this, 'our_settings'));
        if (get_option('plugin_words_to_filter')) add_filter('the_content', array($this, 'filter_logic'));

    }
    // Формируем поля для страницы Options. Очень заморочено.
    function our_settings() {
        add_settings_section( 'replacement-text-section', null, null, 'word-filter-options');
        register_setting( 'replacement-fields', 'replcementText');
        add_settings_field( 'replacement-text', 'Filtered Text', array($this, 'replacement_field_HTML'),'word-filter-options', 'replacement-text-section');
    }

    function replacement_field_HTML() { ?>
        <input type="text" name="replcementText" value="<?php echo esc_attr(get_option('replcementText', '****')); ?> ">
        <p class="description">Leave <strong>blank</strong> to simply remove the filtered words.</p>
    <?php }

    // Реализуем логику поиска по контенту
    function filter_logic($content) {
        $bad_words = explode(',' , get_option('plugin_words_to_filter'));
        $bad_words_trimmed = array_map('trim', $bad_words);
        return str_ireplace($bad_words_trimmed, esc_html(get_option('replcementText', '****')), $content);
    }

    /* Инициализируем наше меню
        add_menu_page('имя в титуле'(doc title), 'имя в side dashbord-menu', 'кто может видеть в меню'
        'slag', 'функция которая ответственно за HTML', 'icon in menu'
        'где меню стоит в admin panel')

        add_submenu_page(parent_slag, doc title, 'текст в меню', capability, menu_slag, callback)
    */
    function our_menu() {
        $main_page_hook = add_menu_page('Words To Filter', 'Word Filter', 'manage_options', 'ourwordfilter', array($this, 'word_filter_page'), 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHZpZXdCb3g9IjAgMCAyMCAyMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik0xMCAyMEMxNS41MjI5IDIwIDIwIDE1LjUyMjkgMjAgMTBDMjAgNC40NzcxNCAxNS41MjI5IDAgMTAgMEM0LjQ3NzE0IDAgMCA0LjQ3NzE0IDAgMTBDMCAxNS41MjI5IDQuNDc3MTQgMjAgMTAgMjBaTTExLjk5IDcuNDQ2NjZMMTAuMDc4MSAxLjU2MjVMOC4xNjYyNiA3LjQ0NjY2SDEuOTc5MjhMNi45ODQ2NSAxMS4wODMzTDUuMDcyNzUgMTYuOTY3NEwxMC4wNzgxIDEzLjMzMDhMMTUuMDgzNSAxNi45Njc0TDEzLjE3MTYgMTEuMDgzM0wxOC4xNzcgNy40NDY2NkgxMS45OVoiIGZpbGw9IiNGRkRGOEQiLz4KPC9zdmc+', 50); // Сохраняем возврат функции(хук), для использования при подключении стилей страницы

        add_submenu_page( 'ourwordfilter', 'Word To Filter', "Words List", 'manage_options', 'ourwordfilter', array($this, 'word_filter_page') );

        $options_page_hook = add_submenu_page( 'ourwordfilter', 'Word Filter Options', "Options", 'manage_options', 'word-filter-options', array($this, 'options_subpage') );
        // После загрузки меню по хуку 'load-{<menu-hook>}' можно определить стили страници меню
        add_action("load-{$main_page_hook}", array($this, 'main_page_assets'));
        add_action("load-{$options_page_hook}", array($this, 'main_page_assets'));
    }
    // Подключаем файл со стилями
    function main_page_assets() {
        wp_enqueue_style('filter_admin_css', plugin_dir_url(__FILE__) . 'styles.css');
    }
    // Проверка разрешений на отправку данных в базу данных. Используем проверку по nonce и возможносей пользователя. Также безопасно сохраняем данные в базу.
    function handle_form() {
        if(wp_verify_nonce( $_POST['our_nonce'], 'save_filter_words' ) AND current_user_can( 'manage_options')) {
            update_option( 'plugin_words_to_filter', sanitize_text_field( $_POST['plugin_words_to_filter'])); ?>
                <div class="updated">
                <p>Your filtered words were saved.</p>
                </div>
        <?php } else { ?>
                <div class="error">
                    <p>Sorry, you do not have permission to perform that action.</p>
                </div>
        <?php }
    }
    // Форма на странице меню. Ввод слов в textarea.В input type="hidden" создаем nonce. Остальное оформление.
    function word_filter_page() { ?>
        <div class="wrap">
            <h1 class="_font-family" >Word Filter</h1>
            <?php if( isset($_POST['justsubmitted']) &&  $_POST['justsubmitted'] == "true") $this->handle_form() ?>
            <form method="POST">
                <input type="hidden" name="justsubmitted" value="true">
                <?php wp_nonce_field('save_filter_words', 'our_nonce'); ?>
                <label for="plugin_words_to_filter"><p class="_font-family" >Enter a <strong>comma-separated</strong> list of words to filter from your site's content</p></label>
                <div class="word-filter__flex-container">
                    <textarea name="plugin_words_to_filter" id="plugin_words_to_filter" placeholder="bad, mean, awful, horrible "><?php echo esc_textarea( get_option( 'plugin_words_to_filter') ); ?></textarea>
                </div>
                <input class="word_filter" type="submit" name="submit" id="submit" value="Save Changes">
            </form>
        </div>
    <?php }

    //Формируем страницу Options.
    function options_subpage() { ?>
        <div class="wrap">
            <h1 class="_font-family">World Filter Options</h1>
            <form action="options.php" method="POST">
                <?php
                settings_errors();
                settings_fields( 'replacement-fields');
                do_settings_sections('word-filter-options');
                submit_button();
                ?>
            </form>
        </div>
    <?php }
}

$pokar_word_filter_plugin = new PokarWordFilterPlugin();