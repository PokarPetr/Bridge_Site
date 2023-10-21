<?php
/** 
 * Этот файл подключает и настраивает все необходимые компоненты темы, включая маршруты,
 * стили, скрипты и другие функции.
 * @package Bridge Montenegro
 */

// Запрос кода для организации поиска по сайту
require get_theme_file_path( '/includes/routes/search-route.php');

// Запрос кода для организации работы с лайками
require get_theme_file_path( '/includes/routes/like-route.php');

// Регистрация новых полей в существующих типах, для последующего использования их ответах на запросы к базе
require get_theme_file_path( '/includes/func/bridge_custom_rest.php');
add_action( 'rest_api_init', 'bridge_custom_rest');

// Запрос кода для отображения баннера на всех типах постов
require get_theme_file_path( '/includes/func/page-banner.php');

// Запрос функции для формирования стилей, шрифтов, а также определения параметров для JavaScript 
require get_theme_file_path( '/includes/func/bridge_files.php');
add_action('wp_enqueue_scripts', 'bridge_files');

// Configures positions for custom nav-menus and add theme supports
require get_theme_file_path( '/includes/func/bridge_features.php');
add_action('after_setup_theme', 'bridge_features');

// Configures the basic query for different post types.
require get_theme_file_path( '/includes/func/bridge_adjast_query.php');
add_action('pre_get_posts', 'bridge_adjast_query');

// Получение Google API key
function bridge_map_key($api) {
$api['key'] = 'AIzaSyCFJUtQIV89Wq1V8g004V-4eHsFk90-2uY';
return $api;
}
add_filter('acf/fields/google_map/api', 'bridge_map_key');

// Redirect subscribers accounts out of admin and into the homepage
require get_theme_file_path( '/includes/func/redirect_subscribers.php');
add_action('admin_init', 'redirect_subscribers');

// Hide admin bar
function hide_admin_bar() {
    $our_current_user = wp_get_current_user();
        if(count($our_current_user->roles) == 1 AND $our_current_user->roles[0] == 'subscriber') {
            show_admin_bar(false);
    }
}
add_action('wp_loaded', 'hide_admin_bar');

// Customize login screen
add_filter('login_headerurl', 'our_header_url');
function our_header_url() {
    return esc_url( site_url('/'));
}

//Добавление стилей на страницу ввода пароля
add_action('login_enqueue_scripts', 'our_login_CSS');
require get_theme_file_path( '/includes/func/our_login_css.php');

// Customize Login Screen Logo
function our_login_logo()
{return get_bloginfo('name');} 
add_filter('login_headertitle', 'our_login_logo', 10, 2);

// Force note posts to be private
require get_theme_file_path( '/includes/func/make_note_private.php');
add_filter('wp_insert_post_data', 'make_note_private', 10, 2);


