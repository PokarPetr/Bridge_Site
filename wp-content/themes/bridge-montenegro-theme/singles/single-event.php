<?php
/**
 * The template for the "event" posts.
 *
 * Отображаем  посты с событиями(даты новых соревнований, разных концертов и вечеринок)
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
                        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('event');   ?>"><i class="fa fa-home" aria-hidden="true"></i>Event Home</a> <span class="metabox__main"><?php the_title(); ?> </span>
                    </p>
                </div>  
        <div class="generic-content"><?php the_content() ?></div>
        <?php
            $related_plays = get_field('related_play');
            if ($related_plays) {
                echo '<hr class="section-break">';
                echo '<h2 class="headline headline--medium">Related Play(s)</h2>';
                echo '<ul class="link-list min-list">';
                foreach($related_plays as $play) { ?>
                    <li><a href="<?php echo get_the_permalink($play); ?>"><?php echo get_the_title( $play); ?></a></li>            
                <?php }
                echo '</ul>';
            }
            
        ?>
        </div>
        
     <?php 
    }
    get_footer();
?>