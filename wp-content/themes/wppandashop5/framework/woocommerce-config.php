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
function cr_add_too_compare(){ ?>
    <li>
        <a class="btn btn-primary compare" href="#" title="<?php _e('Compare','wppandashop5'); ?>">
            <i class="fa fa-exchange"></i>
        </a>
    </li>
<?php }
// подклюбчение кнопки сравнение
add_action( 'woocommerce_after_shop_loop_item','cr_add_too_compare',30 );
