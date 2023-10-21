<?php

// manages logic of page_banner
function page_banner($args = [
    'title' => null,
    'subtitle' => null,
    'image' => null,
]) {
    extract($args);
    $title = $title ?? get_the_title();
    $subtitle = $subtitle ?? get_field('page_banner_subtitle');
    if(!isset($image)){
        if(get_field('page_banner_background_image')){
            $image = get_field('page_banner_background_image')['sizes']['page_banner'];
        } else {
            $image = get_theme_file_uri('/images/ocean.jpg');
        }
    }
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $image; ?>);"></div>
            <div class="page-banner__content container container--narrow">                
                <h1 class="page-banner__title"><?php echo $title; ?></h1>
                <div class="page-banner__intro">
                    <p><?php echo $subtitle; ?></p>
                </div>
            </div>
        </div>
<?php 
}