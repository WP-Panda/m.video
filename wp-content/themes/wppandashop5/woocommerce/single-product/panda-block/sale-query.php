<?php
global $post;
$color = get_post_meta( $post->ID, '_title_sale_colors', true );
$color = ! empty( $color ) ? ' style="color:' . $color . '"' : '';
$text  = get_post_meta( $post->ID, '_text_sale_query', true );
$text =  ! empty( $text ) ? $text : 'Видели товар дешевле? Отправьте ссылку на данный товар. У конкурента будет цена ниже — вернем разницу! Промокод будет отправлен на телефон и е-mail.';
$rules  = get_post_meta( $post->ID, '_rules_sale_query', true );
$rules =  ! empty( $rules ) ? $rules : '#';
$title  = get_post_meta( $post->ID, '_title_sale_query', true );
$title =  ! empty( $title ) ? $title : 'Нашли дешевле? Снизим цену!';

?>
<div class="">
   <h3<?php echo $color ?>>
       <i class="fa fa-thumbs-o-up"></i>
       <?php echo $title ?>
       <i class="fa fa-chevron-right"></i></h3>
    <p>
        <?php echo $text ?>
        <a href="<?php echo $rules ?>">Правила</a>
    </p>
    <p>Для участия в программе вы должны быть авторизованы.</p>
    <a href="<?php echo wp_login_url(); ?>">Войти</a><a href="<?php echo wp_registration_url(); ?>">Регистрация</a>
    <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Закрыть</button>
</div>