<?php
/**
 * Блок нашли дешевле?
 */
function cr_woocommerce_compare() {
    wc_get_template( 'single-product/panda-block/compare.php' );
}

/**
 * Подключение модуцля шашли дешевле
 */
function cr_compare_tab_options_tab_help() { ?>
    <li class="cr_modules"><a href="#cr_compare"><?php _e('В сравнение', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_compare_tab_options_tab_help');

/**
 * Контент блока нашли девле
 */
function cr_compare_tab_options_help() {

    global $post;

    $text  = get_post_meta( $post->ID, '_compare_text', true );
    $block_compare_border = get_post_meta( $post->ID, '_block_compare_border', true );
    ?>
    <div id="cr_compare" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">
            <fieldset class="form-field">
                <div class="wrap">
<?php var_dump($post); ?>
                    <p>
                        <label>Текст кнопки: </label>
                        <input type="text" class="short" row="2" cols="20"  name="_compare_text" id="_compare_text" value="<?php echo $text; ?>"/>
                    </p>

                    <p>
                        <label for="_block_compare_border">Не включать разделитель: </label>
                        <input type="checkbox" name="_block_compare_border" id="_block_compares_border" value="1" <?php checked( $block_compare_border ); ?>/>
                    </p>

                </div>
            </fieldset>
        </div>
    </div>
    <?php
}
add_action('woocommerce_product_write_panels', 'cr_compare_tab_options_help');