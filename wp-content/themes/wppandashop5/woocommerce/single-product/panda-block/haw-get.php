<?php
global $post;
$deck_tab_text_tov = get_post_meta( $post->ID, '_deck_tab_text_tov', true );
$deck_tab_text_tov = $deck_tab_text_tov ? $deck_tab_text_tov : "";
?>
<div class="cr-product-block">

    <div class="block-title-block">
        <h3 class="block-title col-xs-12">Как получить товар?</h3>
    </div>

    <div class="col-xs-8">
        <?php echo $deck_tab_text_tov; ?>
    </div>
    <div class="col-xs-4">

        <?php
        cr_woocommerce_pick_up_in_store();
        cr_woocommerce_shipping_in_home();


        ?>

    </div>

</div>