<?php
namespace PokarFirstPlugin;

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

    

    // Функции для защиты от вредного ввода в выпадающем списке
    function sanitize_location($input) {
    if ($input != '0' AND $input != '1') {
        add_settings_error('wcp_location','wcp_location_error','Display Location must be either Beginning of post or End of post.');
        return get_option('wcp_location');
    }
    return $input;
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