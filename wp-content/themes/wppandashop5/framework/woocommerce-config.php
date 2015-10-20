<?php
/**
 * Query WooCommerce activation
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        return class_exists( 'woocommerce' ) ? true : false;
    }
}

/**
 * Показывать по XX Записей
 */
function woocommerce_catalog_per_page_ordering() {
    ?>
    <li class="show-page">
        <form action="" method="POST" name="results" class="woocommerce-ordering">
            <label>Show:</label>
            <select name="woocommerce-sort-by-columns" id="woocommerce-sort-by-columns" class="sortby styled" onchange="this.form.submit()">
                <?php

                //Get products on page reload
                if  (isset($_POST['woocommerce-sort-by-columns']) && (($_COOKIE['shop_pageResults'] <> $_POST['woocommerce-sort-by-columns']))) {
                    $numberOfProductsPerPage = $_POST['woocommerce-sort-by-columns'];
                } else {
                    $numberOfProductsPerPage = $_COOKIE['shop_pageResults'];
                }

                //  This is where you can change the amounts per page that the user will use  feel free to change the numbers and text as you want, in my case we had 4 products per row so I chose to have multiples of four for the user to select.
                $shopCatalog_orderby = apply_filters('woocommerce_sortby_page', array(
                    //Add as many of these as you like, -1 shows all products per page
                    //  ''       => __('Results per page', 'woocommerce'),
                    '10'        => __('10', 'woocommerce'),
                    '20' 		=> __('20', 'woocommerce'),
                    '-1' 		=> __('All', 'woocommerce'),
                ));

                foreach ( $shopCatalog_orderby as $sort_id => $sort_name )
                    echo '<option value="' . $sort_id . '" ' . selected( $numberOfProductsPerPage, $sort_id, true ) . ' >' . $sort_name . '</option>';
                ?>
            </select>
        </form>
    </li>

    <?php
}

// now we set our cookie if we need to
function dl_sort_by_page($count) {
    if (isset($_COOKIE['shop_pageResults'])) { // if normal page load with cookie
        $count = $_COOKIE['shop_pageResults'];
    }
    if (isset($_POST['woocommerce-sort-by-columns'])) { //if form submitted
        setcookie('shop_pageResults', $_POST['woocommerce-sort-by-columns'], time()+1209600, '/', 'www.your-domain-goes-here.com', false); //this will fail if any part of page has been output- hope this works!
        $count = $_POST['woocommerce-sort-by-columns'];
    }
    // else normal page load and no cookie
    return $count;
}

add_filter('loop_shop_per_page','dl_sort_by_page');
add_action( 'cr_woocommerce_before_shop_loop', 'woocommerce_catalog_per_page_ordering', 20 );


//отключение распродажи
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
//отключение миниатюры
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

//новая миниатюра и распродажа
add_action( 'woocommerce_before_shop_loop_item_title', 'cr_template_loop_product_thumbnail', 10 );

/**
 * Новая миниатюра и распродажа
 * @param string $size - размер миниатюры
 */
function cr_template_loop_product_thumbnail($size = 'shop_catalog'){
    global $post, $product;
    if ( has_post_thumbnail() ) {
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size );
        $thumb = $thumb[0];
        $full = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
        $full = $full[0];
    } elseif ( wc_placeholder_img_src() ) {
        $thumb  = wc_placeholder_img_src();
        $full = $thumb;
    }

    $out = '
    <div class="product-image">
        <a href="' . $full .'" data-lightbox="image-1">
            <div class="image">
                <img src="' . $thumb.'" data-echo="' . $full .'" class="img-responsive" alt="">
            </div>';

    if ( $product->is_on_sale() ) {
        $out .= apply_filters( 'woocommerce_sale_flash', '<div class="tag"><div class="tag-text sale">' . __( 'Sale!', 'woocommerce' ) . '</div></div>', $post, $product );
    }

    $out.= '<div class="hover-effect"><i class="fa fa-search"></i></div>
        </a>
    </div>';

    echo $out;

}

/**
 * Добавление в списое желаний
 */
add_action('woocommerce_after_shop_loop_item','pwlp_product_display',20);

/**
 * Добавление в сравнение
 */
add_action( 'woocommerce_after_shop_loop_item', 'pcp_shop_display_compare', 30);

/** $array = array(
'woocommerce_template_single_title' => 5,
'woocommerce_template_single_rating' => 10,
'woocommerce_template_single_price' => 10,
'woocommerce_template_single_excerpt' => 20,
'woocommerce_template_single_add_to_cart' => 30,
'woocommerce_template_single_meta' => 40,
'woocommerce_template_single_sharing' => 50
);
foreach ($array as $key => $val) {
remove_action('woocommerce_single_product_summary',  $key , $val);
}*/
/**
 * Модули карточки товара
 */
/**
 * woocommerce_single_product_summary hook
 *
 * @hooked woocommerce_template_single_title - 5
 * @hooked woocommerce_template_single_rating - 10
 * @hooked woocommerce_template_single_price - 10
 * @hooked woocommerce_template_single_excerpt - 20
 * @hooked woocommerce_template_single_add_to_cart - 30
 * @hooked woocommerce_template_single_meta - 40
 * @hooked woocommerce_template_single_sharing - 50
 */

/*remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary','woocommerce_template_single_excerpt', 11 );
add_action( 'woocommerce_single_product_summary','woocommerce_template_single_price', 12 );*/

if ( ! function_exists( 'cr_single_variation_add_to_cart_button' ) ) {
    /**
     * Output the add to cart button for variations.
     */
    function cr_single_variation_add_to_cart_button() {
        global $product;
        ?>
        <div class="variations_button point-of-action">
            <div class="quantity">
                <label>Qty:</label>
                <?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
            </div>
            <div class="add-to-cart">
                <button type="submit" class="single_add_to_cart_button button alt btn btn-primary"><i class="fa fa-shopping-cart"></i> <?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
            </div>
            <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>" />
            <input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>" />
            <input type="hidden" name="variation_id" class="variation_id" value="" />
        </div>
        <?php
    }

    remove_action( 'woocommerce_single_variation','woocommerce_single_variation_add_to_cart_button', 20 );
    add_action( 'woocommerce_single_variation','cr_single_variation_add_to_cart_button', 20 );
}




function cr_modules_tab_options_tab() { ?>
    <li class="cr_modules"><a href="#cr_modules_tab"><?php _e('Модули', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_modules_tab_options_tab');

/**
 * Custom Tab Options
 *
 * Provides the input fields and add/remove buttons for custom tabs on the single product page.
 */
function cr_modules_tab_options() {
    global $post;

    $opening_hours_options = array(
        'title' => get_post_meta($post->ID, 'opening_hours_title', true),
        'content' => get_post_meta($post->ID, 'opening_hours_content', true),
    );
    ?>
    <div id="cr_modules_tab" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">
            <p class="form-field day_field_type">
            </p>


            <style>
                #sortable1, #sortable2 {
                    border: 1px solid #eee;
                    width: 40%;
                    min-height: 20px;
                    list-style-type: none;
                    margin: 0;
                    padding: 5px 0 0 0;
                    float: left;
                    margin-right: 10px;
                }
                #sortable1 li, #sortable2 li {
                    margin: 0 5px 5px 5px;
                    padding: 5px;
                    font-size: 1.2em;
                    /* width: 120px; */
                }

            </style>
            <script>
                jQuery(function($) {
                    $(function () {

                        $("#sortable1, #sortable2").sortable({
                            connectWith: ".connectedSortable",
                            update: function( event, ui ) {
                                $array = {};
                                $('#sortable2 li').each(function(){
                                    $array[$(this).html()] = $(this).data('block');
                                });

                                console.log($array);
                                console.log($array.toString());
                                $('#cr_single_modules').val(JSON.stringify($array));
                            }
                        }).disableSelection();



                    });
                });
            </script>

            <?php $array_block=array(
                'Заголовок'         => 'woocommerce_template_single_title',
                'Рейтинг'           => 'woocommerce_template_single_rating',
                'Стоимость'         => 'woocommerce_template_single_price',
                'Описание'          => 'woocommerce_template_single_excerpt',
                'Добавить в корзину'=> 'woocommerce_template_single_add_to_cart',
                'Мета'              => 'woocommerce_template_single_meta',
                'Поделиться'        => 'woocommerce_template_single_sharing'
            ); ?>
            <?php $content = get_post_meta($post->ID, '_cr_single_modules_card', true);

            //if( in_array( 'woocommerce_template_single_sharing',$content_to_field ) ) { ?>
            <fieldset class="form-field">
                <label for="day_field_type"><?php echo __( 'Настройка модулей', 'woocommerce' ); ?></label>
                <div class="wrap">

                        <span> Неактивные </span>
                        <ul id="sortable1" class="connectedSortable">
                            <?php
                            $content_to_field = (array)json_decode($content);
                            foreach ( $array_block as $key =>$val ) {
                                if( ! in_array( $val,$content_to_field ) ) {
                                    echo '<li class="ui-state-default" data-block="' . $val . '">' . $key . '</li>';
                                }
                            }
                            ?>

                        </ul>

                        <span> Активные </span>
                        <ul id="sortable2" class="connectedSortable">
                            <?php foreach ( $content_to_field  as $key =>$val ) {
                                //if( in_array( $val,$content_to_field ) ) {
                                    echo '<li class="ui-state-default" data-block="' . $val . '">' . $key . '</li>';
                                //}
                            } ?>
                        </ul>

                    <input type="hidden" name="_cr_single_modules_card" value="<?php echo htmlspecialchars($content); ?>" id="cr_single_modules" />
                </div>
            </fieldset>
        </div>
    </div>
    <?php ;
}
add_action('woocommerce_product_write_panels', 'cr_modules_tab_options');

// Save Fields
add_action( 'woocommerce_process_product_meta', 'cr_modules_tab_fields_save' );

// Function to save all custom field information from products
function cr_modules_tab_fields_save( $post_id ){

    $content = $_POST['_cr_single_modules_card'];
    //$content = serialize($content);

    update_post_meta( $post_id, '_cr_single_modules_card', $content );

}