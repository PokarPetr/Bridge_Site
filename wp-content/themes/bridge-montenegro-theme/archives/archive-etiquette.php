<?php
/**
 * The template for displaying archive "etiquette" posts.
 *
 * Отображаем  архив постов с правилами торговли
 *
 * @package Bridge Montenegro 
 */
// Загрузка header сайта 
get_header();
page_banner(array(
    'title' => 'All Trading Rules',
    'subtitle' => 'There is something for everyone. Have a look around.',
    'image' => 'http://bridge-montenegro.local/wp-content/uploads/2023/09/adam-jaime-scaled-e1696102890705.jpg',
));
?>
<div class="container container--narrow page-section">
    <ul class='link-list min-list'>
<?php
    // Перебираем посты в цикле
    while(have_posts()) {
        the_post(); ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></li>
    <?php }
    echo paginate_links();
    ?>
    </ul>
    
</div>

<?php
// Загрузка footer сайта
get_footer()
?>

