<?php
/**
* Блок нашли дешевле?
*/
function cr_woocommerce_query_sales() {
wc_get_template( 'single-product/panda-block/sale-query.php' );
}

/**
* Подключение модуцля шашли дешевле
*/
function cr_query_sales_tab_options_tab() { ?>
<li class="cr_modules"><a href="#cr_sales_tab"><?php _e('Нашли дешевле?', 'woothemes'); ?></a></li>
<?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_query_sales_tab_options_tab');

/**
 * Контент блока нашли девле
 */
function cr_query_sales_tab_options() {
    global $post;
    $color = get_post_meta( $post->ID, '_title_sale_colors', true );
    $text  = get_post_meta( $post->ID, '_text_sale_query', true );
    $rules  = get_post_meta( $post->ID, '_rules_sale_query', true );
    $title  = get_post_meta( $post->ID, '_title_sale_query', true );
    $block_query_border = get_post_meta( $post->ID, '_block_query_border', true );
    ?>
    <div id="cr_sales_tab" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">

            <fieldset class="form-field">
                <div class="wrap">

                    <p>
                        <label>Цвет заголовка модуля: </label>
                        <input class="color-field" type="text" name="_title_sale_colors" value="<?php echo $color; ?>"/>
                    </p>

                    <p>
                        <label>Текст заголовка модуля: </label>
                        <input type="text" class="short"  name="_title_sale_query" id="_title_sale_query" value="<?php echo $title; ?>"/>
                    </p>

                    <p>
                        <label>Текст модуля: </label>
                        <textarea class="short" row="2" cols="20"  name="_text_sale_query" id="_text_sale_query"><?php echo $text; ?></textarea>
                    </p>

                    <p>
                        <label>Cылка на страницу Правила: </label>
                        <input type="text" class="short"  name="_rules_sale_query" id="_rules_sale_query" value="<?php echo $rules; ?>"/>
                    </p>

                    <p>
                        <label for="_block_query_border">Не включать разделитель: </label>
                        <input type="checkbox" name="_block_query_border" id="_block_cart_border" value="1" <?php checked( $block_query_border ); ?>/>
                    </p>

                </div>
            </fieldset>
        </div>
    </div>
    <script>
//        (function( $ ) {
//            // Add Color Picker to all inputs that have 'color-field' class
//            $(function() {
//                $('.color-field').wpColorPicker();
//            });
//        })( jQuery );
    </script>
    <?php ;
}
add_action('woocommerce_product_write_panels', 'cr_query_sales_tab_options');