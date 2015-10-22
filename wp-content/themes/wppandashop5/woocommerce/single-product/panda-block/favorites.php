<?php
global $post;
$text = get_post_meta( $post->ID, '_favorites_text', true );
$text = !empty($text) ? $text : 'В избранное';
?>
<p class="cart">
    <a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_favorites_button button alt"><?php echo esc_html( $text ); ?></a>
</p>