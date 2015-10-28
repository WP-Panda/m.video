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
$block_bonus_border = get_post_meta( $post->ID, '_block_bonus_border', true );
$block_bonus_border = 1 == $block_bonus_border ? ' none-border' : '';

?>
<div class="cr-product-block cr-bonuss-block<?php echo $block_bonus_border; ?>">
    <h4 class="name"><span><?php echo $title ?></span>
        <i
            class="fa fa-question"
            data-toggle="popover"
            data-placement="top"
            data-content="<?php echo $text?>"
            ></i>
    </h4>
    <span class="bonus-summ"<?php echo $color ?>><?php echo $price ?></span>
</div>