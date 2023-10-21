<?php
/**
 * The template for displaying archive "event" posts.
 *
 * Отображаем  архив постов с событиями, которые ещё не состоялись
 *
 * @package Bridge Montenegro 
 */
// Загрузка header сайта 
get_header();
/**
 * Выводим баннер.
 */
page_banner(array(
    'title' => 'All Events',
    'subtitle' => 'See what is going on in our world!',
    'image' => 'http://bridge-montenegro.local/wp-content/uploads/2023/09/adam-jaime-scaled-e1696102890705.jpg',
));
?>
<div class="container container--narrow page-section">
<?php
    // Перебираем посты в цикле
    while(have_posts()) {
        the_post(); 
    get_template_part( 'template-parts/content', 'event');
    }
    echo paginate_links();
    ?>
    <hr class="section-break">
    <p>Looking for a recap of our past events? <a href="<?php echo site_url('/past-events'); ?>">Check out past events archive</a></p>

</div>

<?php
// Загрузка footer сайта
get_footer()
?>

