<?php
// Загрузка header сайта
get_header();
/**
 * Выводим баннер на странице блога. 
 */
page_banner(array(
    'title' => 'Welcome to our blog!',
    'subtitle' => 'Keep up with our latest news.',
    'image' => null,
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
                <p><a class="btn btn--blue" href="<?php get_permalink(); ?>">Continue reading &raquo;</a></p>
            </div>
        </div>    
    <?php }
    // Выводим пагинацию для постов
    echo paginate_links();
    ?>
</div>

<?php
// Загрузка footer сайта
get_footer()
?>

