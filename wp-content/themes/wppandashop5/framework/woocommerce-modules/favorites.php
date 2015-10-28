<?php
/**
 * Блок нашли дешевле?
 */
function cr_woocommerce_favorites() {
    wc_get_template( 'single-product/panda-block/favorites.php' );
}

/**
 * Подключение модуцля шашли дешевле
 */
function cr_favorites_tab_options_tab() { ?>
    <li class="cr_modules"><a href="#cr_favorites"><?php _e('В избранное', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_favorites_tab_options_tab');

/**
 * Контент блока нашли девле
 */
function cr_favorites_tab_options() {
    global $post;
    $text  = get_post_meta( $post->ID, '_favorites_text', true );
    $block_favorites_border = get_post_meta( $post->ID, '_block_favorites_border', true );
    ?>
    <div id="cr_favorites" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">

            <fieldset class="form-field">
                <div class="wrap">

                    <p>
                        <label>Текст кнопки: </label>
                        <input type="text" class="short" row="2" cols="20"  name="_favorites_text" id="_favorites_text" value="<?php echo $text; ?>"/>
                    </p>

                    <p>
                        <label for="_block_favorites_border">Не включать разделитель: </label>
                        <input type="checkbox" name="_block_favorites_border" id="_block_favorites_border" value="1" <?php checked( $block_favorites_border ); ?>/>
                    </p>

                </div>
            </fieldset>
        </div>
    </div>
    <?php
}
add_action('woocommerce_product_write_panels', 'cr_favorites_tab_options');