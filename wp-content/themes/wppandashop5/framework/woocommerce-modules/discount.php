<?php
/**
 * Блок нашли дешевле?
 */
function cr_woocommerce_discount() {
    wc_get_template( 'single-product/panda-block/discount.php' );
}

/**
 * Подключение модуцля шашли дешевле
 */
function cr_woocommerce_discount_tab() { ?>
    <li class="cr_discount"><a href="#cr_discount"><?php _e('Скидка', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_woocommerce_discount_tab');

/**
 * Контент блока нашли девле
 */
function cr_woocommerce_discount_options() {
    global $post;
    $discount_card_discount  = get_post_meta( $post->ID, '_discount_card_discount', true );
    $discount_online_credit  = get_post_meta( $post->ID, '_discount_online_credit', true );
    $discount_discount_coupons  = get_post_meta( $post->ID, '_discount_discount_coupons', true );
    $discount_summ  = get_post_meta( $post->ID, '_discount_summ', true );
    $discount_link  = get_post_meta( $post->ID, '_discount_link', true );
    $discount_credit = get_post_meta( $post->ID, '_discount_credit', true );
    $discount_credit_text =  get_post_meta( $post->ID, '_discount_credit_text', true );
    $discount_coupons =  get_post_meta( $post->ID, '_discount_coupons', true );
    $block_discount_border = get_post_meta( $post->ID, '_block_discount_border', true );
    ?>
    <div id="cr_discount" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">

            <fieldset class="form-field">
                <div class="wrap">

                    <p>
                        <label for="_discount_card_discount">Скидка: </label>
                        <input type="checkbox" name="_discount_card_discount" id="discount_card_discount" value="1" <?php checked( $discount_card_discount ); ?>/>
                    </p>
                    <p>
                        <label for="_discount_card_discount">Онлайн кредит: </label>
                        <input type="checkbox" name="_discount_online_credit" id="discount_online_credit" value="1" <?php checked( $discount_online_credit ); ?>/>
                    </p>
                    <p>
                        <label for="_discount_card_discount">Купоны: </label>
                        <input type="checkbox" name="_discount_discount_coupons" id="discount_discount_coupons" value="1" <?php checked( $discount_discount_coupons ); ?>/>
                    </p>


                    <p>
                        <label>Сумма скидки: </label>
                        <input type="text" class="short" name="_discount_summ" id="_discount_summ"  value="<?php echo $discount_summ; ?>"/>
                    </p>

                    <p>
                        <label>Ссылка с заголовка скидка: </label>
                        <input type="text" class="short" name="_discount_link" id="_discount_link"  value="<?php echo $discount_link; ?>"/>
                    </p>

                    <p>
                        <label>Онлайн кредит ссылка с заголовка: </label>
                        <input type="text" class="short" name="_discount_credit" id="_discount_credit"  value="<?php echo $discount_credit; ?>"/>
                    </p>

                    <p>
                        <label>Онлайн кредит текст: </label>
                        <textarea class="short" row="2" cols="20"  name="_discount_credit_text" id="_discount_credit_text"><?php echo $discount_credit_text; ?></textarea>
                    </p>

                    <p>
                        <label>Купоны количество: </label>
                        <input type="text" class="short" name="_discount_coupons" id="_discount_coupons"  value="<?php echo $discount_coupons; ?>"/>
                    </p>

                    <p>
                        <label for="_block_discount_border">Не включать разделитель: </label>
                        <input type="checkbox" name="_block_discount_border" id="_block_discount_border" value="1" <?php checked( $block_discount_border ); ?>/>
                    </p>

                </div>
            </fieldset>
        </div>
    </div>
    <?php ;
}
add_action('woocommerce_product_write_panels', 'cr_woocommerce_discount_options');