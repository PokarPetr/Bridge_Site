<?php
/**
 * The template for displaying single "location" posts.
 *
 * Отображаем  посты с локациями
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
                        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('location');   ?>"><i class="fa fa-home" aria-hidden="true"></i>All Locations</a> <span class="metabox__main"><?php the_title(); ?> </span>
                    </p>
                </div>  
        <div class="generic-content"><?php the_content() ?></div>
        <div class='acf-map'>
    <?php
        $map_location = get_field('map_location');
        $lat = $map_location['lat'];
        $lng = $map_location['lng'];
        ?>
        <div class='marker' data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>">
        <h3><?php the_title(); ?></h3>
        <?php echo $map_location['address']; ?>
        </div>
    
    </div>
    <?php
        // Создание нового запроса и публикация связанных игр.
        $related_plays = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'play',    
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(                     
            array(
            'name' => 'related_location',
            'compare' => 'LIKE',
            'value' => '"' . get_the_ID() . '"'                    
            )
            )
        ));

        if ($related_plays->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Plays Available at This Location</h2>';
            echo '<br>';
            echo '<ul class="min-list link-list">';
            while($related_plays->have_posts()) {
                $related_plays->the_post();?>
                <li>
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>   
              <?php 
            } 
            echo '</ul>';
        }
        wp_reset_postdata( );        
    }
    // Вывод footer страницы
    get_footer();
?>