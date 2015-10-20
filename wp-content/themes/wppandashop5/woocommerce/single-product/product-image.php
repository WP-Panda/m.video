<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product;

?>



		<div id="owl-single-product">
			<?php
			$attachment_ids = $product->get_gallery_attachment_ids();
			$attachment_count = count( $attachment_ids );

			$loop = 0;
			if ( has_post_thumbnail() ) {

				$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
				$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
				$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
				$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
					'title'	=> $image_title,
					'alt'	=> $image_title
				) );

				echo apply_filters( 'woocommerce_single_product_image_html',
					sprintf( '
					 <div class="single-product-gallery-item" id="slide0">
					 <a data-lightbox="image-0" data-title="%s" href="%s">%s</a>
					 </div>',
						$image_title,
						$image_link,
						$image
						 ),
					$post->ID );

				$loop ++;
			} elseif ( ! has_post_thumbnail() && ! $attachment_ids) {

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

			}

			foreach ( $attachment_ids as $attachment_id ) {

				$active = $loop == 0 ? ' active' : '';
				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$image_title 	= esc_attr( get_the_title( $attachment_id ) );
				$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
				$image_link  	= wp_get_attachment_url( $attachment_id );
				$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_single' ), 0, $attr = array(
					'title'	=> $image_title,
					'alt'	=> $image_title
				) );

				$image_class = esc_attr( implode( ' ', $classes ) );

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html',
					sprintf( '
					 <div class="single-product-gallery-item" id="slide%1$s">
					 <a data-lightbox="image-%1$s" data-title="%2$s" href="%3$s">%4$s</a>
					 </div>',
						$loop,
						$image_title,
						$image_link,
						$image
					),
					$post->ID );


				$loop++;
			}
			?>

		</div><!-- /.single-product-slider -->
		<?php do_action( 'woocommerce_product_thumbnails' ); ?>

