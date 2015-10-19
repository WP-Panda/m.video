<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>
<div class="body-content details-v1">
	<div class="container">
		<div class="row">

			<div class='col-md-3 sidebar wow fadeInUp'>
				<?php get_template_part('templates/components/navigation/sidemenu'); ?>
				<div class="sidebar-module-container">
					<div class="related-product clearfix">
						<?php get_template_part('templates/components/sidebar/related-products'); ?>
						<?php get_template_part('templates/components/sidebar/sidebar','advertisement'); ?>
					</div><!-- /.sidebar-filter -->
				</div><!-- /.sidebar-module-container -->
			</div><!-- /.sidebar -->

			<div class="col-md-9 details-page">

				<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action( 'woocommerce_before_main_content' );
				?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; // end of the loop. ?>

				<?php
				/**
				 * woocommerce_after_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' );
				?>

				<?php
				/**
				 * woocommerce_sidebar hook
				 *
				 * @hooked woocommerce_get_sidebar - 10
				 */
				do_action( 'woocommerce_sidebar' );
				?>

			</div> <!-- /.details-page -->

		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /.body-content -->

<?php get_footer(); ?>
