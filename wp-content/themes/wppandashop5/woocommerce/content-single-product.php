<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>



<?php
/**
 * woocommerce_before_single_product hook
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}
?>
<div class="clearfix"></div>
	<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(' row '); ?>>

		<div class="col-xs-12 col-sm-8  gallery-holder block-group">
			<?php

			add_action('woocommerce_before_single_product_summary_cr', 'woocommerce_template_single_title' , 8);
			add_action('woocommerce_before_single_product_summary_cr', 'woocommerce_template_single_rating' , 9);

			?>
			<div class="row">
			<div class="col-xs-8">
			<?php do_action( 'woocommerce_before_single_product_summary_cr' ); ?>
			</div>
			<div class="col-xs-4">h</div>
			</div>
<?php
			/**
			 * woocommerce_before_single_product_summary hook
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>
		</div>
		<div class="summary entry-summary col-xs-12 col-sm-4">

			<?php

			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title' , 5);
			remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating' , 10);



			$content = get_post_meta($post->ID, '_cr_single_modules_card', true);
			$content = (array)json_decode($content);
			if( ! empty( $content ) ) {

				//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title' , 5);
				//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating' , 10);
				remove_action('woocommerce_single_product_summary',  'woocommerce_template_single_price' , 10);
				remove_action('woocommerce_single_product_summary',  'woocommerce_template_single_excerpt' , 20);
				remove_action('woocommerce_single_product_summary',  'woocommerce_template_single_add_to_cart' , 30);
				remove_action('woocommerce_single_product_summary',  'woocommerce_template_single_meta' , 40);
				remove_action('woocommerce_single_product_summary',  'woocommerce_template_single_sharing' , 50);

				$n = 10;

				foreach ($content as $val){
					if($val == 'cr_woocommerce_query_sales') {
						add_action('woocommerce_single_product_summary_one', $val, $n);
						//$val();
						$n = $n + 10;
					} else {
						continue;
					}
				}

				foreach ($content as $val){
					if($val !== 'cr_woocommerce_query_sales') {
						add_action('woocommerce_single_product_summary_two', $val, $n);
						//$val();
						$n = $n + 10;
					}
				}

			}

			function block_pack($post){

				do_action('woocommerce_single_product_summary_one');

				echo '<div class="block-group">';
				do_action('woocommerce_single_product_summary_two');
				echo '</div>';

			}

			add_action('woocommerce_single_product_summary', 'block_pack');



			?>
			<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
			?>

		</div><!-- .summary -->
		<div class="clearfix"></div>
		</div>
</div>
</div>
</div>
</div>
</div>
<div class="container-fluid white borda">
<div class="container top-min">
<div class="row">
		<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>

		<meta itemprop="url" content="<?php the_permalink(); ?>" />
</div>
	</div>
	</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>