<?php
/**
 * The template for the "play" posts.
 *
 * Отображаем  посты с играми(Bridge, Poker, Preferance)
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
                        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('play');   ?>"><i class="fa fa-home" aria-hidden="true"></i>All Plays</a> <span class="metabox__main"><?php the_title(); ?> </span>
                    </p>
                </div>  
        <div class="generic-content"><?php the_field('main_body_content') ?></div>
    <?php
        // Create a new query and public related rule
        $related_rule = get_field('related_rules');

        if ($related_rule) {
          echo '<hr class="section-break">';
          echo '<h2 class="headline headline--medium">' . get_the_title() . ' Rules</h2>';
          echo '<ul class="min-list link-list">';
          foreach($related_rule as $rule) {
            ?><li><a href="<?php echo get_the_permalink($rule); ?>"><?php echo get_the_title($rule); ?></a></li> <?php
          }
          echo '</ul>';
        }
    wp_reset_postdata( );

        // Create a new query and public related etiquette
          $related_etiquette = get_field('related_etiquette');

          if ($related_etiquette) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Trading Etiquette</h2>';
            echo '<ul class="min-list link-list">';
            foreach($related_etiquette as $rule) {
              ?><li><a href="<?php echo get_the_permalink($rule); ?>"><?php echo get_the_title($rule); ?></a></li> <?php
            }
            echo '</ul>';
          }
      wp_reset_postdata( );

        // Create a new query and public related leaders
        $related_leaders = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'leader',    
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => array(                     
            array(
            'name' => 'related_play',
            'compare' => 'LIKE',
            'value' => '"' . get_the_ID() . '"'                    
            )
            )
        ));

        if ($related_leaders->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Leaders</h2>';
            echo '<br>';
            echo '<ul class="professor-cards">';
            while($related_leaders->have_posts()) {
                $related_leaders->the_post();?>
                <li class="professor-card__list-item">
                  <a class="professor-card" href="<?php the_permalink(); ?>">                    
                    <img class="professor-card__image" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'leader_landscape'); ?>">

                    <span class="professor-card__name"><?php the_title(); ?></span>
                  </a>
                </li>   
              <?php 
            } 
            echo '</ul>';
        }
        wp_reset_postdata( );

        // Create a new query and public related events 
        $today = date('Ymd');
        $related_events = new WP_Query(array(
              'posts_per_page' => 2,
              'post_type' => 'event',
              'meta_key' => 'event_date',
              'orderby' => 'meta_value_num',
              'order' => 'ASC',
              'meta_query' => array(
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                  ),                
                array(
                'name' => 'related_play',
                'compare' => 'LIKE',
                'value' => '"' . get_the_ID() . '"'                    
                )
              )
            ));

        if ($related_events->have_posts()) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Event(s)</h2>';
            echo '<br>';
            while($related_events->have_posts()) {
                $related_events->the_post();
                get_template_part( 'template-parts/content', 'event');
            }
        } 
        wp_reset_postdata( );
        // Public related Location 
          $related_location = get_field('related_location');

          if ($related_location) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' is Available at This Location</h2>';
            echo '<ul class="min-list link-list">';
            foreach($related_location as $place) {
              ?><li><a href="<?php echo get_the_permalink($place); ?>"><?php echo get_the_title($place); ?></a></li> <?php
            }
            echo '</ul>';
          }
          ?>
        </div>
     <?php 
    }
    get_footer();
?>