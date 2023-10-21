<!-- Шаблон вывода блогов на главной странице -->

<div class="full-width-split__two">
  <div class="full-width-split__inner">
    <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
    <?php
    // Определяем количество постов на домашней странице
    $homepage_posts = new WP_Query(array(
      'posts_per_page' => 2
    ));
    
    while($homepage_posts->have_posts()) {
      $homepage_posts->the_post();
    ?>
    <!-- Организуем даты написания блогов и их краткое содержание-->
    <div class="event-summary">
      <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>">
      <span class="event-summary__month"><?php the_time('M') ?></span>
      <span class="event-summary__day"><?php the_time('d') ?></span>
      </a>
      <div class="event-summary__content">
        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        <p><?php if(has_excerpt()) { echo get_the_excerpt();} else {echo wp_trim_words(get_the_content(), 18);} ?>
        <a href="<?php the_permalink(); ?>" class="nu gray"> Read more</a>
        </p> 
      </div>
    </div>         
    <?php 
    } 
    wp_reset_postdata();
    ?>
    <!-- Кнопка на все блоги-->          
    <p class="t-center no-margin"><a href="<?php echo site_url('/blog'); ?>" class="btn btn--yellow">View All Blog Posts</a></p>
  </div>        
</div>      
