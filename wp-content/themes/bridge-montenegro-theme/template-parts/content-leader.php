<?php 
/**
 * Отображение блока с игроками 
 * 
 */
?>

<div class="post-item">
    <li class="professor-card__list-item">
        <a class="professor-card" href="<?php the_permalink(); ?>">                    
        <img class="professor-card__image" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'leader_landscape'); ?>">

        <span class="professor-card__name"><?php the_title(); ?></span>
        </a>
    </li> 
</div>