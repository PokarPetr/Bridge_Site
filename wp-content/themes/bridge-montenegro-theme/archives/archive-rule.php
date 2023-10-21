<?php
/**
 * The template for displaying archive "rule" posts.
 *
 * Отображаем  архив постов о правилах игр
 *
 * @package Bridge Montenegro 
 */
// Загрузка header сайта 
get_header();
/**
 * Выводим баннер.
 */
page_banner(array(
    'title' => 'Card Play Rules',
    'subtitle' => 'There live all card play rules. Have a look around for well-played hand.',
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



