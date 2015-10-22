<?php
global $post,$product;
$color = get_post_meta( $post->ID, '_bonus_color', true );
$color = ! empty( $color ) ? ' style="background-color:' . $color . '"' : '';
$text  = get_post_meta( $post->ID, '_bonus_text', true );
$text =  ! empty( $text ) ? $text : 'Начисление бонусных рублей произойдёт после доставки или получения заказа в магазине.  Сумма бонусных рублей определяется в соответствии с правилами М.Видео-Бонус';
$price  = get_post_meta( $post->ID, '_bonus_price', true );
$bonus = (int)($product->get_price()/100*3);
$price =  ! empty( $price ) ? $price : $bonus;
$title  = get_post_meta( $post->ID, '_bonus_title', true );
$title =  ! empty( $title ) ? $title : 'Бонусных рублей за покупуку';

?>
<div class="">
    <span><?php echo $text?></span>
    <span><?php echo $title ?></span><i class="fa fa-question"></i>
    <span<?php echo $color ?>><?php echo $price ?></span>
</div>