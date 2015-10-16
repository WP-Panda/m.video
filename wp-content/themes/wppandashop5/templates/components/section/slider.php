<?php
global $wps5_option;
if( 'blog' == $wps5_option['home_slider_content'] || empty( $wps5_option['home_slider_content']) ) {

    $wp_query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 2));
    $array = array();
    if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post();
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
        $array[] = array(
            'image' => $image[0],
            'title' => get_the_title(),
            'description' => get_the_excerpt(),
            'url' => get_permalink()
        );
    endwhile;
    else: endif;

} elseif ( 'custom' == $wps5_option['home_slider_content'] ) {

    $array = $wps5_option['home-slider'];

} else {
    $array = '';
}

if( ! empty( $array ) ) { ?>
    <div class="furniture-inner hero-style-3" id="hero">
        <div class="sliders owl-main owl-carousel owl-inner-nav owl-ui-lg" id="owl-main">

            <?php foreach( $array as $key ) { ?>

                <div class="item" style="background-image: url(<?php echo $key['image']; ?>);">
                    <div class="container">
                        <div class="slider caption vertical-center text-right">
                            <h1 class="fadeInDown-1"><?php echo $key['title']; ?></h1>
                            <h6 class="fadeInDown-2"><?php echo $key['description']; ?></h6>
                            <div class="slide-btn fadeInDown-3">
                                <a href="<?php echo $key['url']; ?>" class="btn btn-primary"><?php _e('More','wppandashop5'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </div>
    </div>
<?php } ?>