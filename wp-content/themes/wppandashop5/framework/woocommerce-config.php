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


/**
 * Подключение модулей
 */
//основная вкладка ?
require_once 'woocommerce-modules/modules-tab.php';
// нашли дешевле ?
require_once 'woocommerce-modules/sale-query-tab.php';
// цена
require_once 'woocommerce-modules/price.php';
// бонус
require_once 'woocommerce-modules/bonus.php';
// в корзину
require_once 'woocommerce-modules/add-cart.php';
// в избранное
require_once 'woocommerce-modules/favorites.php';
// забрать в мавгазине
require_once 'woocommerce-modules/pick-up-in-store.php';
//доставка на дом
require_once 'woocommerce-modules/shipping-in-home.php';
// скидки
require_once 'woocommerce-modules/discount.php';




// Save Fields
add_action( 'woocommerce_process_product_meta', 'cr_modules_tab_fields_save' );

// Function to save all custom field information from products
function cr_modules_tab_fields_save( $post_id ){

    //конфигурация модулей
    $content = $_POST['_cr_single_modules_card'];
    update_post_meta( $post_id, '_cr_single_modules_card', $content );

    /**
     * Блок нашли дешевле
     */
    //заголовок цвет
    $color = $_POST['_title_sale_colors'];
    update_post_meta( $post_id, '_title_sale_colors', $color );
    // заголовок текст
    $title = $_POST['_title_sale_query'];
    update_post_meta( $post_id, '_title_sale_query', $title );
    // текст
    $text = $_POST['_text_sale_query'];
    update_post_meta( $post_id, '_text_sale_query', $text );
    // правила
    $rules = $_POST['_rules_sale_query'];
    $rules = esc_url($rules);
    update_post_meta( $post_id, '_rules_sale_query', $rules );

    /**
     * Блок бонус
     */
    //сумма
    $prise = $_POST['_bonus_price'];
    update_post_meta( $post_id, '_bonus_price', $prise );
    //заголовок
    $title  = $_POST['_bonus_title'];
    update_post_meta( $post_id, '_bonus_title', $title );
    //текст
    $text  = $_POST['_bonus_text'];
    update_post_meta( $post_id, '_bonus_text', $text );
    //цвет
    $color = $_POST['_bonus_color'];
    update_post_meta( $post_id, '_bonus_color', $color );

    /**
     * Кнопка в корзину
     */
    //текст
    $button_text = $_POST['_button_text'];
    update_post_meta( $post_id, '_button_text', $button_text );

    /**
     * Кнопка в избранное
     */
    //текст
    $favorites_text = $_POST['_favorites_text'];
    update_post_meta( $post_id, '_favorites_text', $favorites_text );

    /**
     * Забрать в магазине
     */
    //текст
    $pick_text  = $_POST['_pick_text'];
    update_post_meta( $post_id, '_pick_text', $pick_text );
    $pick_summ  = $_POST['_pick_summ'];
    //сумма
    update_post_meta( $post_id, '_pick_summ', $pick_summ );
    //ссылка
    $pick_link  = esc_url($_POST['_pick_link']);
    update_post_meta( $post_id, '_pick_link', $pick_link );

    /**
     * Скидки
     */
    //включение ксидки
    $discount_card_discount  = $_POST['_discount_card_discount'];
    update_post_meta( $post_id, '_discount_card_discount', $discount_card_discount );
    //включение кредита
    $discount_online_credit  = $_POST['_discount_online_credit'];
    update_post_meta( $post_id, '_discount_online_credit', $discount_online_credit );
    //включение купонов
    $discount_discount_coupons  = $_POST['_discount_discount_coupons'];
    update_post_meta( $post_id, '_discount_discount_coupons', $discount_discount_coupons );
    //сумма скидки
    $discount_summ  = $_POST['_discount_summ'];
    update_post_meta( $post_id, '_discount_summ', $discount_summ );
    //ссылка скидки
    $discount_link  = $_POST['_discount_link'];
    update_post_meta( $post_id, '_discount_link', $discount_link );
    //ссылка кредита
    $discount_credit = $_POST['_discount_credit'];
    update_post_meta( $post_id, '_discount_credit', $discount_credit );
    //текст кредита
    $discount_credit_text = $_POST['_discount_credit_text'];
    update_post_meta( $post_id, '_discount_credit_text', $discount_credit_text );
    //количество купонов
    $discount_coupons = $_POST['_discount_coupons'];
    update_post_meta( $post_id, '_discount_coupons', $discount_coupons );
}

//Видели товар дешевле? Отправьте ссылку на данный товар. У конкурента будет цена ниже — вернем разницу! Промокод будет отправлен на телефон и е-mail.
