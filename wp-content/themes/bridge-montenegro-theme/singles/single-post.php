<?php
/**
 * The template for the posts.
 *
 * Отображаем основные посты
 *
 * @package Bridge Montenegro 
 */
    // Загрузка header сайта
     get_header();
    while(have_posts()) {
        the_post();
        // Вывод баннера страницы
        page_banner(); ?>
        <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
                    <p>
                        <a class="metabox__blog-home-link" href="<?php echo site_url('/blog');   ?>"><i class="fa fa-home" aria-hidden="true"></i> Blog Home</a> <span class="metabox__main">Posted by <?php the_author_posts_link(); ?>  <?php the_time('d.m.y'); ?> in <?php echo get_the_category_list(', '); ?>  </span>
                    </p>
                </div>  
        <div class="generic-content"><?php the_content() // Вывод содержимого поста ?></div>
        
        </div>
     <?php 

    }
    // Загрузка footer сайта
    get_footer();
?>