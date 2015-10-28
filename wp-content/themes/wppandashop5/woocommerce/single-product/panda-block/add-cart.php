<?php
global $post,$product;
$text = get_post_meta( $post->ID, '_button_text', true );
$text = ! empty($text) ? $text : 'В корзину';
$block_cart_border = get_post_meta( $post->ID, '_block_cart_border', true );
$block_cart_border = 1 == $block_cart_border ? ' none-border' : '';
if ( ! $product->is_purchasable() ) {
    return;
}

$availability      = $product->get_availability();
$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
if ( $product->is_in_stock() ) : ?>

    <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
    <div class="cr-product-block cr-add-cart-block<?php echo $block_cart_border; ?>">
        <form class="cart" method="post" enctype='multipart/form-data'>
            <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

            <input type="hidden" name="quantity" value="1">
            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

            <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $text ); ?></button>

            <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
        </form>
    </div>
    <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
