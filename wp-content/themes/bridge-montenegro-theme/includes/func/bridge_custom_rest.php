<?php
// Регистрация новых полей в существующих типах, для последующего использования их ответах на запросы к базе
function bridge_custom_rest() {
    register_rest_field('post', 'author_name', array(
        'get_callback' => function() {return get_the_author();}));
    register_rest_field('note', 'user_note_count', array(
        'get_callback' => function() {return count_user_posts(get_current_user_id(), 'note');}));
}