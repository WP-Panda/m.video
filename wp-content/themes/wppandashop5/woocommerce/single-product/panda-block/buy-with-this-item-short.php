<div class="cr-product-block">
    <?php
    global $post;

    $values  = get_post_meta( $post->ID, '_buy_with_this', true );
    $buy_with_this = explode(',',$values);


    $arrays = array();
    foreach ( $buy_with_this as $one_product_id ) {
        $name = get_product_category_by_product_id($one_product_id);
        foreach ( $name as $nam ) {
            if( ! get_term_children( $nam->term_id, 'product_cat' ) )
                $arrays[$nam->name] = $nam->slug;
        }

    } ?>

    <div class="featured-product wow fadeInUp">

            <?php
            foreach ( $arrays   as $one_cat => $cat_tov ) { ?>

                    <?php
                    echo do_shortcode( '[product_category per_page ="12" slider=" item category-product" category="' . $cat_tov . '"]');
                    ?>

            <?php  } ?>
    </div><!-- /.fashion-featured -->

</div>