<?php //add_filter( 'woocommerce_shortcode_products_query', 'woocommerce_shortcode_products_orderby' );

function product_loop( $query_args, $atts, $loop_name ) {
    global $woocommerce_loop;
    $products                    = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts ) );
    $columns                     = absint( $atts['columns'] );
    $slider                      = $atts['slider'] ? $atts['slider'] : 'col-sm-4 col-md-3';
    $woocommerce_loop['columns'] = $columns;
    ob_start();
    if ( $products->have_posts() ) :
        ?>

        <?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

        <?php woocommerce_product_loop_start(); ?>
        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
            <div class="<?php echo $slider ?>">

                <?php if(!empty($slider)) { ?>
                <div class="products grid-v2">
                    <?php }
                    //if ( !is_singular() && is_main_query() ) {
                    remove_action('woocommerce_after_shop_loop_item','print_wishlist_link',30);
                    remove_action('woocommerce_after_shop_loop_item', 'cr_woocommerce_discount', 50);
                    remove_action('woocommerce_after_shop_loop_item', 'cr_woocommerce_pick_up_in_store', 60);
                    remove_action('woocommerce_after_shop_loop_item', 'cr_woocommerce_shipping_in_home', 70);
                    //}
                    ?>
                    <?php wc_get_template_part( 'content', 'product' );
                    if ( !is_singular() && is_main_query() ) {
                        add_action('woocommerce_after_shop_loop_item','print_wishlist_link',30);
                        add_action('woocommerce_after_shop_loop_item', 'cr_woocommerce_discount', 50);
                        add_action('woocommerce_after_shop_loop_item', 'cr_woocommerce_pick_up_in_store', 60);
                        add_action('woocommerce_after_shop_loop_item', 'cr_woocommerce_shipping_in_home', 70);
                    }?>
                    <?php if(!empty($slider)) { ?>
                </div>
            <?php } ?>
            </div>
        <?php endwhile; // end of the loop. ?>

        <?php woocommerce_product_loop_end(); ?>

        <?php do_action( "woocommerce_shortcode_after_{$loop_name}_loop" ); ?>

    <?php endif;
    woocommerce_reset_loop();
    wp_reset_postdata();
    if(empty($slider)) {
        return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
    } else {
        return ob_get_clean();
    }
}

//col-sm-4 col-md-3 wow

function maybe_add_category_args( $args, $category, $operator ) {
    if ( ! empty( $category ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'terms'    => array_map( 'sanitize_title', explode( ',', $category ) ),
                'field'    => 'slug',
                'operator' => $operator
            )
        );
    }
    return $args;
}

function product_category($atts){

    $atts = shortcode_atts( array(
        'per_page' => '12',
        'slider' =>'',
        'columns'  => '4',
        'columner' => '',
        'orderby'  => 'title',
        'order'    => 'desc',
        'category' => '',  // Slugs
        'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
    ), $atts );
    if ( ! $atts['category'] ) {
        return '';
    }
    // Default ordering args
    $ordering_args = WC()->query->get_catalog_ordering_args( $atts['orderby'], $atts['order'] );
    $meta_query    = WC()->query->get_meta_query();
    $query_args    = array(
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'orderby'             => $ordering_args['orderby'],
        'order'               => $ordering_args['order'],
        'posts_per_page'      => $atts['per_page'],
        'meta_query'          => $meta_query
    );

    $query_args = maybe_add_category_args($query_args, $atts['category'], $atts['operator'] );


    if ( isset( $ordering_args['meta_key'] ) ) {
        $query_args['meta_key'] = $ordering_args['meta_key'];
    }
    $return = product_loop( $query_args, $atts, 'product_cat' );
    // Remove ordering query arguments
    WC()->query->remove_ordering_args();
    return $return;

}

function yyy()
{
    remove_shortcode( 'product_category');
    add_shortcode( 'product_category','product_category');
}

add_action('init','yyy');