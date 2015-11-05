<?php
/**
 * Блок нашли дешевле?
 */
function cr_woocommerce_price() {
    wc_get_template( 'single-product/panda-block/price.php' );
}

/**
 * Подключение модуцля шашли дешевле
 */
function cr_woocommerce_price_tab() { ?>
    <li class="cr_modules"><a href="#cr_price_tab"><?php _e('Цена', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_woocommerce_price_tab');

/**
 * Контент блока нашли девле
 */
function cr_woocommerce_price_options() {
    global $post;
    $block_price_border = get_post_meta( $post->ID, '_block_price_border', true );
    ?>
    <div id="cr_price_tab" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">

            <fieldset class="form-field">
                <div class="wrap">
                    <p>
                        <label for="_discount_card_discount">Не включать разделитель: </label>
                        <input type="checkbox" name="_block_price_border" id="_block_price_border" value="1" <?php checked( $block_price_border ); ?>/>
                    </p>
                </div>
            </fieldset>
        </div>
    </div>
<!--    <script>-->
<!--        (function( $ ) {-->
<!--            // Add Color Picker to all inputs that have 'color-field' class-->
<!--            $(function() {-->
<!--                $('.color-field').wpColorPicker();-->
<!--            });-->
<!--        })( jQuery );-->
<!--    </script>-->
    <?php ;
}
add_action('woocommerce_product_write_panels', 'cr_woocommerce_price_options');