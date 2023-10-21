<?php
/**
 * The template for displaying archive "location" posts.
 *
 * Отображаем  архив мест проведения встреч
 *
 * @package Bridge Montenegro 
 */
// Загрузка header сайта 
get_header();
/**
 * Выводим баннер.
 */
page_banner(array(
    'title' => 'Our Locations',
    'subtitle' => 'We have several convenient locations.',
    'image' => 'http://bridge-montenegro.local/wp-content/uploads/2023/09/adam-jaime-scaled-e1696102890705.jpg',
));
?>
<div class="container container--narrow page-section">
    <div class='acf-map'>
    <?php
    // Перебираем посты в цикле
    while(have_posts()) {
        the_post(); 
        $map_location = get_field('map_location');
        $lat = $map_location['lat'];
        $lng = $map_location['lng'];
        ?>
        <div class='marker' data-lat="<?php echo $lat; ?>" data-lng="<?php echo $lng; ?>">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php echo $map_location['address']; ?>
        </div>
    <?php } ?>
    </div>
    
</div>

<?php
// Загрузка footer сайта
get_footer()
?>


