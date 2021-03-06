<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	$loop 		= 0;
	//$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	?>
	<div class="single-product-gallery-thumbs gallery-thumbs clearfix">
		<div id="owl-single-product-thumbnails">

			<?php
			$attachment_ids = $product->get_gallery_attachment_ids();
			$attachment_count = count( $attachment_ids );

			$loop = 0;
			if ( has_post_thumbnail() ) {

				$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
				$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
				$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
				$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_thumbnail' ), array(
					'title'	=> $image_title,
					'alt'	=> $image_title
				) );

				echo apply_filters( 'woocommerce_single_product_image_html',
					sprintf( '
					  	<div class="item">
					 			%3$s
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
				$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
					'title'	=> $image_title,
					'alt'	=> $image_title
				) );

			//	$image_class = esc_attr( implode( ' ', $classes ) );

				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html',
					sprintf( '
					 <div class="single-product-gallery-item" id="slide%1$s">
					 %4$s
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
		</div>
	</div>
	<?php
}
