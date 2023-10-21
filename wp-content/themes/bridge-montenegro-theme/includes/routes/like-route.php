<?php
//код для организации работы с лайками

add_action( 'rest_api_init', 'bridge_like_routes');

// Регистрируем routes(REST API URL) для создания и удаления Like
function bridge_like_routes() {
    register_rest_route('bridge/v1', 'manage_like', array(
        'methods' => 'POST',
        'callback' => 'create_like',
    ));

    register_rest_route('bridge/v1', 'manage_like', array(
        'methods' => 'DELETE',
        'callback' => 'delete_like',
    ));
}

function create_like($data) {
    // Только зарегистрированные пользователи создают Like
    if (is_user_logged_in()) {
        $player = sanitize_text_field($data['leader_id']);

        // Только если ещё не ставили Like, можно его поставить
        $exist_query = new WP_Query(array(
                    'author' => get_current_user_id(),
                    'post_type' => 'like',
                    'meta_query' => array(
                        array(
                            'key' => 'liked_leader_id',
                            'compare' => '=',
                            'value' => $player,
                        ),
                    )
                ));
        
        if($exist_query->found_posts == 0 AND get_post_type($player) == 'leader') {
            // с помощью Wordpress функции создаём новый пост в Like
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'post_title' => '4th PHP Test',
                'meta_input' => array(
                    'liked_leader_id' => $player, 
                ),
            ));
        } else {
            die("Invalid leader id");
        }
        
        
    } else {
        die('Only logged in users can create a like');
    }
 
}

function delete_like($data) {
    //Получаем ID из JavaScript response
    $like_id = sanitize_text_field($data['like']);
    // с помощью Wordpress функции удаляем пост из Like
    if (get_current_user_id() == get_post_field( 'post_author', $like_id ) AND get_post_type($like_id) == 'like') {
        wp_delete_post( $like_id, true);
        return "Congrats, Like deleted";    
    } else {
        die('You do not have permition to delete that.');
    }
}