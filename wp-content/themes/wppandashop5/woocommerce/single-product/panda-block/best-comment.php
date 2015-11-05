<?php

global $post,$product;

$args = array(
    'status' => 'approve',
    'number' => '1',
    'post_id' => $post->ID,
);


$comments = get_comments($args);

$n = 1;
foreach($comments as $comment){
    if($n > 1) continue;
    $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

    ?>
    <div class="blog cr-product-block">

        <div class="block-title-block">
            <h3 class="block-title col-xs-10">Самый полезный отзыв</h3>
            <a class="col-xs-2 inner-tabber" href="#tab-rev">Посмотреть все <i class="fa fa-angle-right"></i></a>
        </div>
        <div class="clearfix"></div>

        <div class="blog-comments wow fadeInUp animated">
            <ul class="media-list">
                <li class="media">
                    <div class="media-left">
                        <?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

                            <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
                                <span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
                            </div>

                        <?php endif; ?>
                        <a href="#">
                            <?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '74' ), '' ); ?>
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading"><?php $comment->comment_author; ?></h4>
                        <div class="comment-action">
                            <ul class="list-inline list-unstyled">
                                <li><time itemprop="datePublished" datetime="<?php echo $comment->comment_date; ?>"><?php echo $comment->comment_date; ?></time></li>
                            </ul>
                        </div>
                        <p><?php echo $comment->comment_content; ?></p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <?php
    $n++;
}