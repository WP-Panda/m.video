<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $post,$product;

$args = array(
    'status' => 'approve',
    'number' => '1000',
    'post_id' => $post->ID,
);


$comments = get_comments($args);
$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();
?>
<div class="cr-product-block hidd">
    <?php if ( $rating_count > 0 ) : ?>
        <div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                    <span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
                        <strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( __( 'out of %s5%s', 'woocommerce' ), '<span itemprop="bestRating">', '</span>' ); ?>
                        <?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'woocommerce' ), '<span itemprop="ratingCount" class="rating">' . $rating_count . '</span>' ); ?>
                    </span>
            <?php if ( comments_open() ) : ?>
                <b>(<?php echo $review_count; ?>)</b>
            <?php endif;  ?>
        </div>
        <?php
        $array = array(1=>0,2=>0,3=>0,4=>0,5=>0);
        $index = 100/$review_count;
        foreach($comments as $comment){
            $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
            $array[(int)$rating] = (int)$array[$rating] + 1;
        } ?>

        <div class="cr-rating-lines col-xs-6">
            <?php
            foreach ( $array as $key => $one ) { ?>
                <span class="col-xs-2"><?php echo $key . ' ' .  rus_numbers($key,array('звезда','звезды','звезд')) ?></span>
                <div class="cr-rating-liner col-xs-8">
                    <span style="width: <?php echo $one*$index ?>%" class="cr-rating-line"></div>
                <span class="col-xs-2">(<?php echo $one ?>)</span>
            <?php } ?>

        </div>
    <?php endif; ?>
    <div class="cr-rating-lines col-xs-6">
        <div>
            Оставьте свой отзыв о товаре: <br>
            <b><?php the_title() ?></b>
        </div>
        <div class="col-xs-12 text-center outer-top-xs">
            <a href="#tab-rev" class="btn btn-primary inner-tabber">Оставить свой отзыв</a>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="border inner-xs"></div>
    <?php
    comments_template();
    ?>
</div>
