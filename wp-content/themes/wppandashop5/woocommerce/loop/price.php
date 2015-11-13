<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post,$product;

?>
<div class="priser-conta">
<div class="col-xs-8" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

	<div class="reliat">

		<div class="product-details-summary-prices details-product-price">
			<?php if ( $product->is_on_sale() ) : ?>
				<del class="w-100-b">
					<span class="amount">
						<?php echo $product->get_regular_price(); ?>
					</span>
				</del>
			<?php endif; ?>

			<ins  class="w-100-b<?php if (  $product->is_on_sale() == false ) : ?> pat-line<?php endif; ?>">
            <span class="amount">
                <?php echo $product->get_display_price(); ?>
            </span>
			</ins>
		</div>
	</div>
	<?php if ( $product->is_on_sale() ) : ?>
		<div class="product-details-summary-prices details-product-price w-100">
			<span><?php echo $product->get_regular_price()-$product->get_display_price();?></span> <b class="ec">ЭКОНОМИЯ</b>
		</div>
	<?php endif; ?>

	<meta itemprop="price" content="<?php echo $product->get_price() ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_option('woocommerce_currency'); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

</div>
