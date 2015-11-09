<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header();
global $wps5_option;



$term_id = get_queried_object()->term_id;
$children = get_term_children( $term_id, 'product_cat' );
$crsh5_meta =  get_option( '_crsh5_category_' . $term_id );

$img_url =  (! empty( $crsh5_meta ) && ! empty( $crsh5_meta['fa_limit'] )) ? $crsh5_meta['fa_limit'] :( ! empty( $wps5_option['main_banner'] ) ? $wps5_option['main_banner']['url']  : '');
$img_link = (! empty( $crsh5_meta ) && ! empty( $crsh5_meta['bn_link']  )) ? $crsh5_meta['bn_link'] : ( ! empty( $wps5_option['main_banner_link'] )	? $wps5_option['main_banner_link'] : "");

?>
<div class="body-content outer-top-xs">
	<div class="container">
		<div class="row category-v1 outer-bottom-sm">
			<?php
			/**
			 * woocommerce_before_main_content hook
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action( 'woocommerce_before_main_content' );
			?>

			<?php if( ! $children ) : ?>

				<?php echo '<a href="' . $img_link . '" title=""><img class="main-banner" src="' . $img_url . '" alt=""></a>'; ?>

			<?php endif; ?>

			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

				<div class="outer-bottom-xs border-b-sol"><h1 class="page-title"><?php woocommerce_page_title(); ?></h1></div>

			<?php endif; ?>


			<div class="col-md-3 col-sm-12 sidebar">

				<?php get_sidebar();?>

			</div><!-- /.sidebar -->


			<div class=" col-md-9 col-sm-12 outer-bottom-sm">

				<?php if(  $children ) : ?>

					<?php echo '<a href="' . $img_link . '" title=""><img class="main-banner" src="' . $img_url . '" alt=""></a>'; ?>
					<?php wc_get_template( 'single-product/panda-block/info-list.php' ); ?>

				<?php endif; ?>

				<?php if ( have_posts() ) : ?>

					<?php if( ! $children ) : ?>
						<div class="controls-product-top">
							<div class="controls-product-item row">

								<div class="col-sm-3 col-md-3">
									<div class="product-item-view">
										<?php /* ul class="nav nav-tabs">
											<li class="active"><a data-toggle="tab" href="#grid-container"><i class="icon fa fa-th"></i></a></li>
											<li><a data-toggle="tab" href="#list-container"><i class="icon fa fa-th-list"></i></a></li>
										</ul */ ?>
									</div>
								</div>
								<?php
								/**
								 * woocommerce_before_shop_loop hook
								 *
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								remove_action( 'woocommerce_before_shop_loop','woocommerce_result_count',20 );
								do_action( 'woocommerce_before_shop_loop' );
								?>

							</div><!-- /.row -->
						</div><!-- /.controls-product-top -->
					<?php endif; ?>

					<div class="search-result-container">
						<div id="myTabContent" class="tab-content">

							<div class="tab-pane active " id="grid-container">
								<div class="category-product  inner-top-xs">
									<div class="row">
										<?php
										woocommerce_product_loop_start();
										$delay = 0;
										?>

										<?php woocommerce_product_subcategories(); ?>

										<?php while ( have_posts() ) : the_post(); ?>

											<div class="col-sm-4 col-md-3 wow fadeInUp" data-wow-delay="<?php echo (float)($delay/10);?>s">
												<div class="products grid-v1">
													<?php wc_get_template_part( 'content', 'product' ); ?>
												</div><!-- /.products -->
											</div><!-- /.item -->
											<?php $delay++;  endwhile; // end of the loop. ?>

										<?php woocommerce_product_loop_end(); ?>

									</div><!-- /.row -->
								</div><!-- /.category-product -->

							</div><!-- /.tab-pane -->
							<div class="tab-pane outer-top-vs"  id="list-container">
								<div class="category-product ">


								</div><!-- /.category-product -->
							</div><!-- /.tab-pane #list-container -->

						</div><!-- /.tab-content -->

					</div><!-- /.search-result-container -->

					<?php
					/**
					 * woocommerce_after_shop_loop hook
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					do_action( 'woocommerce_after_shop_loop' );
					?>

				<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

					<?php wc_get_template( 'loop/no-products-found.php' ); ?>

				<?php endif; ?>

				<?php
				/**
				 * woocommerce_after_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' );
				?>
			</div><!-- /.col -->
			<?php
			/**
			 * woocommerce_archive_description hook
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
			?>
		</div><!-- /.row -->

	</div><!-- /.container -->

	<?php /**
	/**
	 * woocommerce_sidebar hook
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	//do_action( 'woocommerce_sidebar' );
	?>
</div><!-- /.body-content -->
<?php get_footer( 'shop' ); ?>
