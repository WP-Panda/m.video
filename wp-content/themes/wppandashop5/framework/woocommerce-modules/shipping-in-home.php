<?php
/**
 * Блок нашли дешевле?
 */
function cr_woocommerce_shipping_in_home() {
    wc_get_template( 'single-product/panda-block/shipping-in-home.php' );
}

/**
 * Подключение модуцля шашли дешевле
 */
function cr_woocommerce_shipping_in_home_tab() { ?>
    <li class="cr_modules"><a href="#cr_shipping_in_home"><?php _e('Доставка на дом', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_woocommerce_shipping_in_home_tab');

/**
 * Контент блока нашли девле
 */
function cr_woocommerce_shipping_in_home_options() {
    global $post;
    $shipping_link  = get_post_meta( $post->ID, '_shipping_link', true );
    $shipping_text_1  = get_post_meta( $post->ID, '_shipping_text_1', true );
    $shipping_summ_1  = get_post_meta( $post->ID, '_shipping_summ_1', true );
    $shipping_text_2  = get_post_meta( $post->ID, '_shipping_text_2', true );
    $shipping_summ_2  = get_post_meta( $post->ID, '_shipping_summ_2', true );
    $block_shipping_border = get_post_meta( $post->ID, '_block_shipping_border', true );
    ?>
    <div id="cr_shipping_in_home" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">

            <fieldset class="form-field">
                <div class="wrap">

                    <p>
                        <label>Ссылка с блока: </label>
                        <input type="text" class="short" name="_shipping_link" id="_shipping_link" value="<?php echo $shipping_link; ?>"/>
                    </p>

                    <p>
                        <label>Текст блока Завтра и позже: </label>
                        <textarea class="short" row="2" cols="20"  name="_shipping_text_1" id="_shipping_text_1"><?php echo $shipping_text_1; ?></textarea>
                    </p>

                    <p>
                        <label>Стоимость Завтра и позже: </label>
                        <input type="text" class="short" name="_shipping_summ_1" id="_shipping_summ_1"  value="<?php echo $shipping_summ_1; ?>"/>
                    </p>

                    <p>
                        <label>Текст блока Сегодня: </label>
                        <textarea class="short" row="2" cols="20"  name="_shipping_text_2" id="_shipping_text_2"><?php echo $shipping_text_2; ?></textarea>
                    </p>

                    <p>
                        <label>Стоимость Сегодня: </label>
                        <input type="text" class="short" name="_shipping_summ_2" id="_shipping_summ_2"  value="<?php echo $shipping_summ_2; ?>"/>
                    </p>

                    <p>
                        <label for="_block_shipping_border">Не включать разделитель: </label>
                        <input type="checkbox" name="_block_shipping_border" id="_block_shipping_border" value="1" <?php checked( $block_shipping_border ); ?>/>
                    </p>

                </div>
            </fieldset>
        </div>
    </div>
    <?php ;
}
add_action('woocommerce_product_write_panels', 'cr_woocommerce_shipping_in_home_options');