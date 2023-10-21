<?php
/**
 * The template for the past event page.
 *
 * Отображаем  страницу с событиями которые уже состоялись
 *
 * @package Bridge Montenegro 
 */
// Загрузка header сайта 
get_header();
// Вывод баннера страницы
page_banner(array(
  'title' => 'Past Events',
  'subtitle' => 'A recap of our past events.',
  'image' => 'http://bridge-montenegro.local/wp-content/uploads/2023/09/adam-jaime-scaled-e1696102890705.jpg',
));
?>
<div class="container container--narrow page-section">
<?php
     $today = date('Ymd');
     $past_events = new WP_Query(array(
    'paged' => get_query_var('paged', 1),
       'posts_per_page' => 10,
       'post_type' => 'event',
       'meta_key' => 'event_date',
       'orderby' => 'meta_value_num',
       'order' => 'DESC',
       'meta_query' => array(
         array(
           'key' => 'event_date',
           'compare' => '<',
           'value' => $today,
           'type' => 'numeric'
         )
       )
     ));
    while($past_events->have_posts()) {
        $past_events->the_post(); 
        get_template_part( 'template-parts/content', 'event');
      }
    echo paginate_links(array(
        'total' => $past_events->max_num_pages
    ));
    ?>
    

</div>

<?php
// Вывод footer страницы
get_footer()
?>

