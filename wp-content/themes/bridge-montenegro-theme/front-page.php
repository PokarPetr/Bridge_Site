<?php
/**
 * The template for the front page.
 *
 * Отображаем главную страницу
 *
 * @package Bridge Montenegro 
 */

    // Загрузка header сайта
    get_header(); 
    // Загружаем баннер для front-page
    require get_theme_file_path( '/includes/front-page/front-page-banner.php');
    ?>    
    <div class="full-width-split group">
      <?php 
      // Загружаем Upcoming Events блок 
      require get_theme_file_path( '/includes/front-page/upcoming-events.php');
      // Загружаем From Our Blogs блок 
      require get_theme_file_path( '/includes/front-page/from-our-blogs.php'); 
      ?>
    </div>        
    <?php
    // Загружаем Hero Slider блок 
    require get_theme_file_path( '/includes/front-page/custom-hero-slider.php'); 
    // Загрузка footer сайта
    get_footer();
?>
