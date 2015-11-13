<?php
global $post;
$pick_text  = get_post_meta( $post->ID, '_pick_text', true );
$pick_text  = ! empty( $pick_text ) ? $pick_text : 'Бесплатно,	Премия';
$pick_summ  = get_post_meta( $post->ID, '_pick_summ', true );
$pick_summ  = ! empty( $pick_summ ) ? $pick_summ : '500';
$pick_link  = get_post_meta( $post->ID, '_pick_link', true );
$pick_link_class = ! empty ( $pick_link ) ? '' :'inner-tabber abbrer';
$pick_link  = ! empty ( $pick_link ) ? $pick_link : '#tab-shops';
$block_store_border = get_post_meta( $post->ID, '_block_store_border', true );
$block_store_border = 1 == $block_store_border ? ' none-border' : '';
$block_shipping_kog = get_post_meta( $post->ID, '_block_shipping_kog', true );
if( !empty( $block_shipping_kog ) ) {
    if( $block_shipping_kog == 'no' ) {
        $kog = __('Недоступно', 'woocommerce');
        $ou = 1;
    } elseif( $block_shipping_kog == 'one' ) {
        $kog = __( 'Сегодня', 'woocommerce' );
    } elseif( $block_shipping_kog == 'two' ) {
        $kog =  __( 'Завтра', 'woocommerce' );
    } elseif( $block_shipping_kog == 'three') {
        $kog = __('В течении недели', 'woocommerce');
    }
} else {
    $kog = 'Сегодня';
}

$ouj = !empty( $ou ) ? ' noner' : '';

if ( is_singular()){ ?>
    <div class="cr-product-block cr-shippin-block<?php echo $block_store_border; ?>">
        <h4><a href="<?php echo $pick_link; ?>" class="<?php echo $pick_link_class; ?>">Забрать в магазине</a></h4>
        <p><?php echo $pick_text; ?> <span><?php echo $pick_summ; ?></span></p>
        <i class="fa fa-shopping-cart abs-right"></i>
    </div>
<?php } else { ?>
    <div class="shopes<?php $ouj; ?>">
        <strong class="product-tile-delivery-option-type">
            <i class="product-tile-delivery-option-ico fa fa-shopping-cart abs-right"></i>
            Забрать в магазине
        </strong>
        <span class="product-tile-delivery-option-value"><?php echo $kog; ?></span>
    </div>
<?php }