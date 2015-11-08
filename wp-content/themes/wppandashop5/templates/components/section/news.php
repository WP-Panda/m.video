<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 09.11.2015
 * Time: 1:25
 */

global $wps5_option;

$home_news = $wps5_option['n_new_block'];
if( ! empty( $home_news ) ) {
    $array = explode(',',$home_news);
} else {
    $args = array(
        'numberposts' => 5,
        'post_type' => 'product',
        'post_status' => 'publish'
    );

    $result = wp_get_recent_posts($args);

    $array = array();
    foreach ($result as $post) {
        // print_r($post);
        $array[] = $post['ID'];
    }
} ?>
<div class="cr-product-block homer">

    <div class="block-title-block">
        <h3 class="block-title col-xs-12">Новинки</h3>
    </div>

    <div class="owl-news">
        <?php foreach ( $array as $item ) { ?>
            <?php echo do_shortcode('[products ids="' . $item . '"]'); ?>
        <?php } ?>
    </div>

</div>