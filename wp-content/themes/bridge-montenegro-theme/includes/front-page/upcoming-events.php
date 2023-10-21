<!-- Шаблон вывода будущих событий на главной странице -->

<div class="full-width-split__one">          
    <div class="full-width-split__inner">
        <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>        
        <?php
        $today = date('Ymd');
        $homepage_events = new WP_Query(array(
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
            )
            )
        ));

        while($homepage_events->have_posts()) {
            $homepage_events->the_post();
        get_template_part( 'template-parts/content', 'event');
        } 
        ?>
        <p class="t-center no-margin"><a href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue" style="background-color: gray">View All Events</a></p>
            

    </div>
</div>