<?php
/** 
 * Страница традиционного(не JavaScript) поиска
 * 
 * @package Bridge Montenegro 
 */
// Загрузка header сайта
get_header();
// Отображаем баннер страницы результатов поиска
page_banner(array(
    'title' => 'Search Results',
    'subtitle' => 'You searched for &ldquo;' . esc_html(get_search_query(false)) . '&rdquo;',
    'image' => null,
));
?>
<div class="container container--narrow page-section">
<?php
if(have_posts()) {
    // Если есть результаты поиска, выводим их
    while(have_posts()) {
        the_post(); 
        get_template_part('template-parts/content', get_post_type());      
       }
    echo paginate_links();
} else { 
    // Если результатов нет, выводим сообщение об отсутствии результатов
    echo '<h2 class="headline headline--small-plus">No results match that search.</h2>';
}
// Выводим форму поиска для возможности повторного поиска  
get_search_form();    
    
?>
</div>

<?php
// Загружаем footer сайта
get_footer()
?>

