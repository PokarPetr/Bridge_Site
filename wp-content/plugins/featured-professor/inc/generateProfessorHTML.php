<?php
function generate_professor_HTML($id) {
    $prof_posts = new WP_Query (array(
        'post_type' => 'leader',
        'p' => $id
    ));
    while($prof_posts->have_posts()) {
        $prof_posts->the_post();
        ob_start(); ?>
        <div class="professor-callout">
            <div class="professor-callout__photo" style="background-image: url(<?php the_post_thumbnail_url("professor_portrait") ?>)"></div>
            <div class="professor-callout__text">
                <h5><?php echo esc_html(get_the_title()); ?></h5>
                <p><?php echo wp_trim_words(get_the_content(), 30); ?></p>
                <?php
                    $related_plays = get_field('related_play');
                    if ($related_plays) { ?>
                        <p><?php echo esc_html(get_the_title()); ?> plays:
                            <?php foreach($related_plays as $key => $play){
                            echo get_the_title($play);
                            if ($key != array_key_last($related_plays) && count($related_plays) > 1) {
                            echo ', ';
                            }
                            }
                            ?>.</p>
                    <?php }
                ?>
                <p><strong><a href="<?php the_permalink(); ?>">Learn more about <?php echo esc_html(get_the_title()); ?> &raquo;</a></strong></p>
            </div>
        </div>
        <?php
        wp_reset_postdata();
        return ob_get_clean();
    }
}