<?php
/**
 * The template for displaying archive posts.
 *
 * Отображаем  архив постов 
 *
 * @package Bridge Montenegro 
 */
// Загрузка header сайта 
get_header();
/**
 * Выводим баннер.
 */
page_banner(array(
    'title' => get_the_archive_title(),
    'subtitle' => get_the_archive_description(),
    'image' => 'http://bridge-montenegro.local/wp-content/uploads/2023/09/adam-jaime-scaled-e1696102890705.jpg',
));
?>
<div class="container container--narrow page-section">
<?php
    // Перебираем посты в цикле
    while(have_posts()) {
        the_post(); ?>
        <div class="post-item">
            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class='metabox'>
                <p>Posted by <?php the_author_posts_link(); ?>  <?php the_time('d.m.y'); ?> in <?php echo get_the_category_list(', '); ?>  </p>
            </div>
            <div class='generic-content'>
                <?php the_excerpt(); ?>
                <p><a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
            </div>

        </div>
    
    <?php }
    echo paginate_links();
    ?>
    

</div>

<?php
// Загрузка footer сайта
get_footer()
?>

