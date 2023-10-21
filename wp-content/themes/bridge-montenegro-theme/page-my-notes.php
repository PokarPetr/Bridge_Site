<?php
/**
 * The template for displaying the user's notes page.
 * This template displays a page for creating new notes, viewing, and editing existing private notes of the user.
 * Отображаем  страницу создания новых, показа и редактирования старых приватных записок пользователя
 *
 * @package Bridge Montenegro 
 */
//Проверяем, авторизован ли пользователь; если нет, перенаправляем на главную страницу.

if(!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/')));
    exit;
}
// Загрузка header сайта    
get_header();
    // Перебираем посты в цикле
    while(have_posts()) {
        the_post();
        //Выводим баннер на странице.
        page_banner();
        /*
        * Отображаем форму для создания новых записок
        * Сообщение Note limit reached: изначально скрыто и отображается, когда лимит достигнут (JavaScript добавляет класс 'active').        
        */
        ?> 
        <div class="container container--narrow page-section">
            <div class="create-note">
                <h2 class="headline headline--medium">Create New Note</h2>
                <input class="new-note-title" placeholder='Your Title'>
                <textarea class="new-note-body" placeholder='Your New Note...'></textarea>
                <span class="submit-note">Create Note</span>
                <span class="note-limit-message">Note limit reached: Delete the existing note to make room for a new one.</span>
            </div>
            <!-- id="my-notes" используется в JavaScript-->
            <ul class="min-list link-list" id="my-notes">
                
            <?php
            // Запрашиваем записи пользователя с типом 'note' и выводим все записи (-1).
                $user_notes = new WP_Query(array(
                    'post_type' => 'note',
                    'post_per_page' => -1,
                    'author' => get_current_user_id()
                ));
                // Перебираем записи пользователя.
                while($user_notes->have_posts()){
                    $user_notes->the_post();
                    /*
                     * Добавляем ID записи (который позже используется при удалении записи).
                     * Убираем "Private: " из заголовка записи с помощью str_replace() 
                     * Используем атрибут "readonly" для блокировки редактирования содержания записи.
                     * При редактировании(клик на кнопку Edit) этот атрибут убирается.
                    */
                    ?>
                    <li data-id="<?php the_ID(); ?>">                        
                        <input readonly class="note-title-field" value="<?php echo str_replace('Private: ','', esc_attr(get_the_title())); ?>">
                        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                        <textarea readonly class="note-body-field"><?php echo esc_textarea(wp_strip_all_tags(get_the_content())); ?></textarea>
                        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save Changes</span>
                    </li>
                    <?php } // Заканчиваем цикл записей пользователя.
                    ?>
            </ul>
        </div>     
     <?php 
    }
    // Загрузка footer сайта
    get_footer();
?>