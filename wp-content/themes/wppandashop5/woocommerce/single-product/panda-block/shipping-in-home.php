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
$block_shipping_border = get_post_meta( $post->ID, '_block_shipping_border', true );
$block_shipping_border = 1 == $block_shipping_border ? ' none-border' : '';
if ( is_singular()){ ?>


    <div class="cr-product-block cr-shippin-block<?php echo $block_shipping_border; ?>">
        <h4><a href="<?php echo $shipping_link; ?>">Доставить на дом</a></h4>
        <p><?php echo $shipping_text_1; ?> - <span><?php echo $shipping_summ_1; ?></span></p>
        <p><?php echo $shipping_text_2; ?> - <span><?php echo $shipping_summ_2; ?></span></p>
        <i class="fa fa-truck  abs-right"></i>
    </div>
<?php } else { ?>
    <div class="homes">
        <strong class="product-tile-delivery-option-type"><i class="product-tile-delivery-option-ico fa fa-truck  abs-right"></i>
            Доставить на дом
        </strong>
        <span class="product-tile-delivery-option-value"><?php echo $shipping_summ_1; ?></span>
    </div>
<?php }
