<?php
/**
 * Блок нашли дешевле?
 */
function cr_woocommerce_add_cart() {
    wc_get_template( 'single-product/panda-block/add-cart.php' );
}

/**
 * Подключение модуцля шашли дешевле
 */
function cr_add_cart_tab_options_tab() { ?>
    <li class="cr_modules"><a href="#cr_add_cart"><?php _e('Добавить в корзину', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_add_cart_tab_options_tab');

/**
 * Контент блока нашли девле
 */
function cr_add_cart_tab_options() {
    global $post;
    $text  = get_post_meta( $post->ID, '_button_text', true );
    ?>
    <div id="cr_add_cart" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">

            <fieldset class="form-field">
                <div class="wrap">

                    <p>
                        <label>Текст кнопки: </label>
                        <input type="text" class="short" row="2" cols="20"  name="_button_text" id="_button_text" value="<?php echo $text; ?>"/>
                    </p>

                </div>
            </fieldset>
        </div>
    </div>
<?php
}
add_action('woocommerce_product_write_panels', 'cr_add_cart_tab_options');