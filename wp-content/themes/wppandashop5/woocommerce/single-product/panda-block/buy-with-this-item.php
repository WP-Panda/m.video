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
    <div class="tabbable tabs-left container">
        <ul class="nav nav-tabs col-xs-3" role="tablist">
            <?php
            $i = 0;
            foreach ( $arrays   as $one_cat => $cat_tov ) {
                $active = $i == 0 ? 'active' : '';
                echo '<li role="presentation" class="' . $active .  '"><a href="#' . $one_cat . '" aria-controls="home" role="tab" data-toggle="tab">' . $one_cat . '</a></li>';
                $i ++;
            } ?>
        </ul>

        <div class="tab-content col-xs-9" style="float: right;">
            <?php
            $i = 0;
            foreach ( $arrays   as $one_cat => $cat_tov ) {
                $active = $i == 0 ? ' active' : '';
                ?>
                <div id="<?php echo $one_cat; ?>" role="tabpanel"  class="container tab-pane<?php echo $active; ?>">
                    <?php  echo do_shortcode( '[product_category per_page ="12" category="' . $cat_tov . '"]'); ?>
                </div>
                <?php  $i ++;
            } ?>
        </div>
    </div>

</div>