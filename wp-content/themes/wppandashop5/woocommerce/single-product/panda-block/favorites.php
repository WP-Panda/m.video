<?php
global $post;
$text = get_post_meta( $post->ID, '_favorites_text', true );
$text = !empty($text) ? $text : 'В избранное';
$block_favorites_border = get_post_meta( $post->ID, '_block_favorites_border', true );
$block_favorites_border = 1 == $block_favorites_border ? ' none-border' : '';

?>
<div class="cr-product-block cr-wishlist-block<?php echo $block_favorites_border; ?>">
    <?php $class = new Uni_WC_Wishlist();
    $class->print_wishlist_link();   ?>
    <?php // echo cr_product_display($text); ?>
</div>

