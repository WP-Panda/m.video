<?php
/**
 * Блок нашли дешевле?
 */
function cr_woocommerce_pick_up_in_store() {
    wc_get_template( 'single-product/panda-block/pick-up-in-store.php' );
}

/**
 * Подключение модуцля шашли дешевле
 */
function cr_woocommerce_pick_up_in_store_tab() { ?>
    <li class="cr_modules"><a href="#cr_pick_up_in_store_tab"><?php _e('Забрать в магазине', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_woocommerce_pick_up_in_store_tab');

/**
 * Контент блока нашли девле
 */
function cr_woocommerce_pick_up_in_store_options() {
    global $post;
    $pick_text  = get_post_meta( $post->ID, '_pick_text', true );
    $pick_summ  = get_post_meta( $post->ID, '_pick_summ', true );
    $pick_link  = get_post_meta( $post->ID, '_pick_link', true );
    $block_store_border = get_post_meta( $post->ID, '_block_store_border', true );
    $block_shipping_kog = get_post_meta( $post->ID, '_block_shipping_kog', true );
    ?>
    <div id="cr_pick_up_in_store_tab" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">

            <fieldset class="form-field">
                <div class="wrap">

                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_zab_4',
                            'label'       => __( 'Когда', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  $block_shipping_kog,
                            'options' => array(
                                'no'   => __( 'недоступно', 'woocommerce' ),
                                'one'   => __( 'Сегодня', 'woocommerce' ),
                                'two'   => __( 'Завтра', 'woocommerce' ),
                                'three' => __( 'В течении недели', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <p>
                        <label>Ссылка с блока: </label>
                        <input type="text" class="short" name="_pick_text" id="_pick_text" value="<?php echo $pick_link; ?>"/>
                    </p>

                    <p>
                        <label>Сумма премии: </label>
                        <input type="text" class="short" name="_pick_summt" id="_pick_summ" value="<?php echo $pick_summ; ?>"/>
                    </p>

                    <p>
                        <label>Текст блока: </label>
                        <textarea class="short" row="2" cols="20"  name="_button_text" id="_favorites_text"><?php echo $pick_text; ?></textarea>
                    </p>

                    <p>
                        <label for="_block_store_border">Не включать разделитель: </label>
                        <input type="checkbox" name="_block_store_border" id="_block_store_border" value="1" <?php checked( $block_store_border ); ?>/>
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
    <?php
}
add_action('woocommerce_product_write_panels', 'cr_woocommerce_pick_up_in_store_options');