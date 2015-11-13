<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

//if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
	//return;
?>

<?php if ( $rating_html = get_rating_html_cr() ) : ?>
	<?php echo $rating_html; ?>
<?php endif; ?>
