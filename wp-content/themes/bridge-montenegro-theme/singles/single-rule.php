<?php
/**
 * The template for the "rule" posts.
 *
 * Отображаем  посты с правилами игр
 *
 * @package Bridge Montenegro 
 */
// Загрузка header сайта
 get_header();
    while(have_posts()) {
        the_post();
        // Вывод баннера страницы
        page_banner();
        ?>
        <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('rule');   ?>"><i class="fa fa-home" aria-hidden="true"></i>All Card Play Rules</a> <span class="metabox__main"><?php the_title(); ?> </span>
                    </p>
                </div>  
        <div class="generic-content"><?php the_content() ?></div>
    
     <?php 
    }
    // Вывод footer страницы
    get_footer();
?>