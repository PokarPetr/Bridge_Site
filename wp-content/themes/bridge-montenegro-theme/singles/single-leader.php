<?php
/**
 * The template for the "leader" posts.
 *
 * Отображаем  посты с игроками(ну или лучшими игроками)
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
        <div class="generic-content">
            <div class="row group">
                <div class="one-third"><?php the_post_thumbnail('leader_portrait'); ?></div>
                <div class="two-thirds">
                <?php
                /* Собираем все посты с лайками текущего игрока,
                потом считаем их в $like_count->found_posts; */
                $like_count = new WP_Query(array(
                    'post_type' => 'like',
                    'meta_query' => array(
                        array(
                            'key' => 'liked_leader_id',
                            'compare' => '=',
                            'value' => get_the_ID(),
                        ),
                    )
                ));
                // Устанавливаем значение $exist_status(yes or no) в зависимости от того лайкал текущий юзер игрока или нет
                if (is_user_logged_in()) {
                    $exist_status = array_filter($like_count->posts, fn($post) => $post->post_author == get_current_user_id()) ? 'yes' : 'no';
                }
                // Запрос установить ID в data-like и потом удалять только Like, которые сам создал
                $exist_query = new WP_Query(array(
                    'author' => get_current_user_id(),
                    'post_type' => 'like',
                    'meta_query' => array(
                        array(
                            'key' => 'liked_leader_id',
                            'compare' => '=',
                            'value' => get_the_ID(),
                        ),
                    )
                ));
                ?>
                    <span class="like-box" data-like="<?php if (isset($exist_query->posts[0]->ID)) echo $exist_query->posts[0]->ID; ?>" data-player="<?php the_ID(); ?>" data-exists="<?php echo $exist_status; ?>">
                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                    <i class="fa fa-heart" aria-hidden="true"></i>
                    <span class="like-count"><?php echo $like_count->found_posts; ?></span>
                    </span>   
                <?php the_content(); ?>
                </div>
            </div>
        </div>
        <?php
        $related_plays = get_field('related_play');
        if ($related_plays) {
            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Main subject(s)</h2>';
            echo '<ul class="link-list min-list">';
            foreach($related_plays as $play) { ?>
                <li><a href="<?php echo get_the_permalink($play); ?>"><?php echo get_the_title($play); 
        ?>
        </a></li>            
        <?php }
            echo '</ul>';
        }            
        ?>
    </div>        
<?php 
}
// Вывод footer страницы
get_footer();
?>