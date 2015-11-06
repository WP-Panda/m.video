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

$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

	<article <?php comment_class('comment'); ?>>

		<div class="media-left">
			<?php echo get_avatar( $comment, 70 ); ?>
			<?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

				<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
					<span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
				</div>

			<?php endif; ?>
		</div>

		<div class="media-body">

			<?php if ( $comment->comment_approved == '0' ) : ?>

				<p class="meta"><em><?php _e( 'Your comment is awaiting approval', 'woocommerce' ); ?></em></p>

			<?php else : ?>

				<h4 class="author-name media-heading"><?php comment_author(); ?></h4>

				<div class="comment-action">
					<ul class="list-inline list-unstyled">
						<li>
							<time <?php comment_time( 'c' ); ?> class="comment-time">
                                        <span class="date">
                                            <?php comment_date(); ?>
                                        </span>
                                        <span class="time">
                                            <?php comment_time(); ?>
                                        </span>
						</li>
					</ul>
				</div>

			<?php endif; ?>

			<div itemprop="description" class="description"><?php comment_text(); ?></div>
		</div>
	</article>
