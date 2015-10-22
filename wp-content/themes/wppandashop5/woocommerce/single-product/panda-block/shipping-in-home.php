<?php
global $post;
$shipping_link  = get_post_meta( $post->ID, '_shipping_link', true );
$shipping_link = ! empty($shipping_link) ? $shipping_link : '#';
$shipping_text_1  = get_post_meta( $post->ID, '_shipping_text_1', true );
$shipping_text_1 = ! empty($shipping_text_1) ? $shipping_text_1 : 'Завтра и позже';
$shipping_summ_1  = get_post_meta( $post->ID, '_shipping_summ_1', true );
$shipping_summ_1 = ! empty($shipping_summ_1) ? $shipping_summ_1 : '490';
$shipping_text_2  = get_post_meta( $post->ID, '_shipping_text_2', true );
$shipping_text_2 = ! empty($shipping_text_2) ? $shipping_text_2 : 'Сегодня';
$shipping_summ_2  = get_post_meta( $post->ID, '_shipping_summ_2', true );
$shipping_summ_2 = ! empty($shipping_summ_2) ? $shipping_summ_2 : '990';
?>

<div class="div">
    <a href="<?php echo $shipping_link; ?>">Доставить на дом</a>
    <p><?php echo $shipping_text_1; ?> <span><?php echo $shipping_summ_1; ?></span></p>
    <p><?php echo $shipping_text_2; ?> <span><?php echo $shipping_summ_2; ?></span></p>
    <i class="fa fa-truck"></i>
</div>

