<?php
/**
 * Display single product reviews (comments)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.2
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="blog">
	<div id="comments" class="blog-write-comment">
		<h2><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
				printf( _n( '%s review for %s', '%s reviews for %s', $count, 'woocommerce' ), $count, get_the_title() );
			else
				_e( 'Reviews', 'woocommerce' );
			?></h2>

		<?php if ( have_comments() ) : ?>

			<ul class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ul>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links(
						apply_filters(
								'woocommerce_comment_pagination_args',
								array(
										'prev_text' => '&larr;',
										'next_text' => '&rarr;',
										'type'      => 'list',
								)
						)
				);
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'woocommerce' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->id ) ) : ?>

		<div id="review_form_wrapper"  class="blog">
			<div id="review_form"  class="blog-write-comment">
				<?php
				$commenter = wp_get_current_commenter();
				$req = get_option( 'require_name_email' );
				$aria_req = ( $req ? " aria-required='true'" : '' );

				$comment_form = array(
						'title_reply'          => have_comments() ? __( 'Add a review', 'woocommerce' ) : __( 'Be the first to review', 'woocommerce' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
						'title_reply_to'       => __( 'Leave a Reply to %s', 'woocommerce' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'submit_button'     =>
								'<div class="col-md-12 outer-bottom-small">'.
								'<input name="%1$s" type="submit" id="%2$s" class="%3$s bbtn-upper btn btn-primary checkout-page-button" value="%4$s" />'.
								'</div>',
						'comment_field' =>
								'<div class="col-md-12">' .
								'<div class="form-group">' .
								'<textarea id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . __( 'Your Comment','wppandashop5' ) . '"></textarea>'.
								'</div>'.
								'</div>',
						'fields' => array(
								'author' =>
										'<div class="col-md-4">' .
										'<div class="form-group">' .
										'<input id="author" class="form-control text-input" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
										'" size="30"' . $aria_req . ' placeholder="' . __( 'Your Name','wppandashop5' ) . ( $req ? ' *' : '' ) . '"/>'.
										'</div>' .
										'</div>',
								'email' =>
										'<div class="col-md-4">' .
										'<div class="form-group">' .
										'<input id="email" class="form-control text-input" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
										'" size="30"' . $aria_req . ' placeholder="' . __( 'Your email','wppandashop5' ) . ( $req ? ' *' : '' ) . '"/></p>'.
										'</div>' .
										'</div>',
						),
						'logged_in_as'  => '',
				);

				if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
					$comment_form['must_log_in'] = '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'woocommerce' ), esc_url( $account_page_url ) ) . '</p>';
				}

				if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
					$comment_form['comment_field'] = '<div class="col-md-4"><div class="form-group comment-form-rating"><label for="rating">' . __( 'Your Rating', 'woocommerce' ) .'</label><select name="rating" id="rating">
							<option value="">' . __( 'Rate&hellip;', 'woocommerce' ) . '</option>
							<option value="5">' . __( 'Perfect', 'woocommerce' ) . '</option>
							<option value="4">' . __( 'Good', 'woocommerce' ) . '</option>
							<option value="3">' . __( 'Average', 'woocommerce' ) . '</option>
							<option value="2">' . __( 'Not that bad', 'woocommerce' ) . '</option>
							<option value="1">' . __( 'Very Poor', 'woocommerce' ) . '</option>
						</select></div></div>';
				}

				$comment_form['comment_field'] .= '<div class="col-md-12">' .
								'<div class="form-group">' .
								'<textarea id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true" placeholder="' . __( 'Your Comment','wppandashop5' ) . '"></textarea>'.
								'</div>'.
								'</div>';

				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?>
			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'woocommerce' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
