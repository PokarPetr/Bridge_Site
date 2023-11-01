<?php
function related_post_HTML($id) {
    $post_about_this_player = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'post',
        'meta_query' => array(
            array(
                'key' => 'featured_professor',
                'compare' => '=',
                'value' => $id
            )
        )
    ));
    ob_start();
    if ($post_about_this_player->found_posts) { ?>
    <p><?php echo esc_html(get_the_title()); ?> is mentioned in the followed posts: </p>
    <ul>
        <?php 
        while($post_about_this_player->have_posts()) {
            $post_about_this_player->the_post();?>
            <li><a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a></li>
            <?php
        }
        ?>
    </ul>
    <?php }
    wp_reset_postdata(  );
    return ob_get_clean();
}