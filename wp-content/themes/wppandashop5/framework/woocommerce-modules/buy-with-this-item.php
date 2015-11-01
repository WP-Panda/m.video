<?php
/**
 * Блок нашли дешевле?
 */
function cr_woocommerce_buy_with_this_item() {
    wc_get_template( 'single-product/panda-block/buy-with-this-item.php' );
}

/**
 * Подключение модуцля шашли дешевле
 */
function cr_woocommerce_buy_with_this_item_tab() { ?>
    <li class="cr_buy_with_this_item"><a href="#cr_buy_with_this_item"><?php _e('С этим товаром покупают', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_woocommerce_buy_with_this_item_tab');

/**
 * Контент блока нашли девле
 */
function cr_woocommerce_buy_with_this_item_options() {
    global $post;
    $values  = get_post_meta( $post->ID, '_buy_with_this', true );
    $buy_with_this = explode(',',$values);

    ?>
    <div id="cr_buy_with_this_item" class="panel woocommerce_options_panel">
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css">
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
        <div class="club-opening-hours">

            <fieldset class="form-field">
                <div class="wrap">

                    <p>
                        <?php
                        $out = '<select id="multiple-select-box" class="js-example-basic-multiple" data-placeholder="Type to search cities" name="_buy_with_this_sel" multiple="multiple">';
                        $args = array(
                            'post_type'             => 'product',
                            'post_status'           => 'publish',
                            'ignore_sticky_posts'   => 1,
                            'posts_per_page'        => 10000,
                        );

                        $products = new WP_Query($args);

                        if ( $products->have_posts() ) {

                            while ( $products->have_posts() ) {

                                $products->the_post();

                                $selected = (in_array($post->ID,$buy_with_this)) ? ' selected="selected"': '';
                                $out .= '<option value="' . $post->ID . '"' . $selected  . '>' . $post->post_title . '</option>';

                            }

                        }

                        wp_reset_query();
                        $out .= '</select>';

                        woocommerce_wp_hidden_input(
                            array(
                                'id'    => '_buy_with_this',
                                'value' => $values
                            )
                        );

                        echo $out;


                        ?>
                        <a class="ccc" href="#">submit</a>
                    </p>

                    <script>
                        $eventSelect = jQuery('#multiple-select-box').select2();

                        $eventSelect.on("change", function (e) { jQuery('#_buy_with_this').val($eventSelect.val()) });

                        jQuery('a.ccc').click(function (e) {
                            alert(jQuery('#multiple-select-box').val());
                        });
                    </script>

                </div>
            </fieldset>
        </div>
    </div>
    <?php
}
add_action('woocommerce_product_write_panels', 'cr_woocommerce_buy_with_this_item_options');