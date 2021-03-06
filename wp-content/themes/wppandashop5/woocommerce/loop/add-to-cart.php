<?php
/**
 * Loop Add to Cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>
<div class="col-xs-4">
<?php
echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( '<span class="add-cart-button"><a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="btn btn-primary button %s product_type_%s red-btn p-5-15">%s</a></span>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( $product->id ),
		esc_attr( $product->get_sku() ),
		esc_attr( isset( $quantity ) ? $quantity : 1 ),
		$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
		esc_attr( $product->product_type ),
		//esc_html( $product->add_to_cart_text() )
		'<i class="fa fa-shopping-cart fa-2x"></i>'
	),
$product );

echo "</div></div>";