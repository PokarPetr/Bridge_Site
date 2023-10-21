<div class="hero-slider">
    <div data-glide-el="track" class="glide__track">
        <div class="glide__slides">
            <?php 
            $hero_slides = new WP_Query(array(
                'post_type' => 'slide',
                'posts_per_page' => -1,                
            ));
             
            while ($hero_slides->have_posts()) {
                $hero_slides->the_post();
                $image = get_field('hero_slide_backgroung_image')['sizes']['slide'];
                ?>

                    <div class="hero-slider__slide" style="background-image: url(<?php echo $image; ?>);">
                        <div class="hero-slider__interior container">
                            <div class="hero-slider__overlay">
                                <h2 class="headline headline--medium t-center"><?php the_title(); ?></h2>
                                <p class="t-center"><?php the_field('hero_slide_subtitle'); ?></p>
                                <p class="t-center no-margin"><a href="<?php  the_permalink(); ?>" class="btn btn--blue"><?php the_field('hero_slide_button_text'); ?></a></p>
                            </div>
                        </div> 
                    </div>                     
                <?php 
                }            
            ?>
        </div>  
        <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
    </div>
</div>
        