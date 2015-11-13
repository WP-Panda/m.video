<?php
global $post;
$color = get_post_meta( $post->ID, '_title_sale_colors', true );
$mcolor = ! empty( $color ) ? ' style="color:' . $color . '"' : '';
$bcolor = ! empty( $color ) ? ' style="background-color:' . $color . '"' : '';
$text  = get_post_meta( $post->ID, '_text_sale_query', true );
$text =  ! empty( $text ) ? $text : 'Видели товар дешевле? Отправьте ссылку на данный товар. У конкурента будет цена ниже — вернем разницу! Промокод будет отправлен на телефон и е-mail.';
$rules  = get_post_meta( $post->ID, '_rules_sale_query', true );
$rules =  ! empty( $rules ) ? $rules : '#';
$title  = get_post_meta( $post->ID, '_title_sale_query', true );
$title =  ! empty( $title ) ? $title : 'Нашли дешевле? Снизим цену!';
$block_query_border = get_post_meta( $post->ID, '_block_query_border', true );
$block_query_border = 1 == $block_query_border ? ' none-border' : '';

?>
<div class="cr-product-block cr-query-block<?php echo $block_query_border; ?>">
    <h4 class="name"<?php echo $mcolor ?>>
        <i class="fa fa-thumbs-o-up"<?php echo $bcolor ?>></i>
        <strong><?php echo $title ?></strong>
        <i class="fa fa-chevron-right"></i>
    </h4>
    <div class="cr-query-hide">
        <p class="border-b-da paddind-b-20">
            <?php echo $text ?><br>
            <a href="<?php echo $rules ?>">Правила</a>
        </p>
        <div class="auto-block">
            <p>Для участия в программе вы должны быть авторизованы.</p>
            <ul>
                <li>
                    <a href="<?php echo wp_login_url(); ?>">Войти</a>
                </li>
                <li>
                    <a href="<?php echo wp_registration_url(); ?>">Регистрация</a>
                </li>
            </ul>
            <a href="javascript:void(0);" id="query-hider" class="btn-upper btn btn-primary checkout-page-button w-100 p-12-0">Закрыть</a>
        </div>
    </div>
</div>