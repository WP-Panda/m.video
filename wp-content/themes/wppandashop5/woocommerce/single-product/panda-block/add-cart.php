<?php
global $post;
$text = get_post_meta( $post->ID, '_button_text', true );
$text = ! empty($text) ? $text : 'В корзину';
?>
<p class="cart">
    <a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button button alt"><?php echo esc_html( $text ); ?></a>
</p>