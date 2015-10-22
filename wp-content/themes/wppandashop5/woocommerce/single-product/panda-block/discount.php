<?php
global $post;

$discount_card_discount  = get_post_meta( $post->ID, '_discount_card_discount', true );
$discount_online_credit  = get_post_meta( $post->ID, '_discount_online_credit', true );
$discount_discount_coupons  = get_post_meta( $post->ID, '_discount_discount_coupons', true );
$discount_summ  = get_post_meta( $post->ID, '_discount_summ', true );
$discount_summ  = ! empty($discount_summ) ? $discount_summ : '5';
$discount_link  = get_post_meta( $post->ID, '_discount_link', true );
$shipping_link = ! empty($shipping_link) ? $shipping_link : '#';
$discount_credit = get_post_meta( $post->ID, '_discount_credit', true );
$discount_credit = ! empty($discount_credit) ? $discount_credit : '#';
$discount_credit_text =  get_post_meta( $post->ID, '_discount_credit_text', true );
$discount_credit_text = ! empty($discount_credit_text) ? $discount_credit_text : 'Получите кредит – онлайн! Оформление кредита происходит в корзине. Решение банка – в режиме онлайн.';
$discount_coupons =  get_post_meta( $post->ID, '_discount_coupons', true );
$discount_coupons = ! empty($discount_coupons) ? $discount_coupons : '5000';
?>

<div class="div">
    <?php if ( 1 == $discount_card_discount ) { ?>
    <p>
        <a href="<?php echo $discount_link; ?>">Скидка <?php echo $discount_summ; ?>%</a>
    </p>
    <?php } ?>
    <?php if ( 1 == $discount_online_credit ) { ?>
    <p>
        <span><?php echo $discount_credit_text; ?> <a href="<?php echo $discount_credit; ?>">подробнее</a><span>
        <a href="<?php echo $discount_credit; ?>">Онлайн кредит</a>
    </p>
    <?php } ?>
    <?php if ( 1 == $discount_discount_coupons ) { ?>
    <p>
        <span>+ «М.Купоны» на <?php echo $discount_coupons; ?> рублей</span>
    </p>
    <?php } ?>
</div>

