<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $post,$product;

$block_price_border = get_post_meta( $post->ID, '_block_price_border', true );
$block_price_border = 1 == $block_price_border ? ' none-border' : '';

?>
<div class="cr-product-block cr-prise-block<?php echo $block_price_border; ?>" itemprop="offers" itemscope itemtype="http://schema.org/Offer">

    <div class="<?php if ( $product->is_on_sale() ) : ?>border-b-da<?php endif; ?> reliat">
        <div class="product-details-summary-price-label cr-bot-price">
            <h4>Цена</h4>
        </div>

        <div class="product-details-summary-prices details-product-price">
            <?php if ( $product->is_on_sale() ) : ?>
                <del>
                <span class="amount">
                    <?php echo $product->get_regular_price(); ?>
                </span>
                </del>
            <?php endif; ?>

            <ins>
            <span class="amount">
                <?php echo $product->get_display_price(); ?>
            </span>
            </ins>
        </div>
    </div>
    <?php if ( $product->is_on_sale() ) : ?>
        <div class="product-details-summary-price-label">
            <b>Экономия</b>
        </div>
        <div class="product-details-summary-prices details-product-price">
            <?php echo $product->get_regular_price()-$product->get_display_price();?>
        </div>
    <?php endif; ?>

    <meta itemprop="price" content="<?php echo $product->get_price() ?>" />
    <meta itemprop="priceCurrency" content="<?php echo get_option('woocommerce_currency'); ?>" />
    <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />

</div>
