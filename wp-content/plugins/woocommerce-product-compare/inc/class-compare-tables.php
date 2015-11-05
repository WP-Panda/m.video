<?php
/**
 * Bolder Compare Products Table Class.
 *
 * @author 		Bolder Elements
 * @category 	Inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'BE_Compare_Tables' ) ) :

	/**
	 * BE_Compare_Settings
	 */
	class BE_Compare_Tables {

		public $items;
		public $data;
		public $categories;
		protected static $instance = NULL;

		/**
		 * Constructor.
		 */
		public function __construct() {

			add_action( 'the_content', array( &$this, 'add_page_content' ) );
			add_filter( 'body_class', array( &$this, 'body_class_names' ) );

		}


		/**
		 * Constructor.
		 */
		public static function get_instance() {
			// create an object
			NULL === self::$instance and self::$instance = new self;

			return self::$instance; // return the object
		}


		/**
		 * Add WooCommerce class names to the body of this page
		 */
		function body_class_names( $classes ) {
			global $post;

			$compare_page = get_option( 'be_compare_page' );
			if( is_page() && $post->ID == $compare_page ) :
				$classes[] = 'woocommerce';
				$classes[] = 'woocommerce-page';
			endif;

			return $classes;
		}


		/**
		 * Display the comparison table for the session page
		 */
		function add_page_content( $content ) {
			global $post;

			$compare_page = get_option( 'be_compare_page' );
			if( is_page() && $post->ID == $compare_page ) :
				$content = $this->generate_table();
			endif;

			return $content;
		}


		/**
		 * Create the comparison table for the session or shortcode usage
		 */
		function generate_table( $products = array() ) {
			// Check usage: shortcode or session
			if( !empty( $products ) ) {
				// Use session variables to generate table
				$this->prepare_items( array_unique( $products ) );
				return $this->display();
			} else {
				// Add specified products to comparison table
				if( !empty( $_SESSION[ 'be_compare_products' ] ) ) {
					$this->prepare_items( array_unique( $_SESSION[ 'be_compare_products' ] ) );
					return $this->display();
				} else
					return apply_filters( 'be_compare_table_no_products', __( 'No products have been added yet', 'be-compare-products' ) . '...' );
			}
		}


		/**
		 * Determine how to sort data
		 */
		function usort_reorder( $a, $b ) {

			// Determine sort order
			if( isset( $a['order'] ) && isset( $b['order'] ) )
				return strcmp( $a[ 'order' ], $b[ 'order' ] );

			return 1;
		}


		/**
		 * Prepare items for output
		 */
		function prepare_items( $products ) {

			$categories = get_option( 'be_compare_categories' );
			$selCats = $allCats = $data = $feature_data = array();

			foreach( $products as $pid ) {
				$pid = (int) $pid;
				$enabled = sanitize_title( get_post_meta( $pid, 'enable_compare_product', true ) );
				$category = sanitize_title( get_post_meta( $pid, 'selcat_compare_product', true ) );

				if( $enabled != 'yes' ) break;
				if( !$category || empty( $category ) ) break;

				$this->items[] = $pid;
			}
			$this->items = array_unique( $this->items );

			// Setup categories and features
			foreach( $this->items as $pid ) $selCats[] = get_post_meta( $pid, 'selcat_compare_product', true );
			$selCats = array_unique( $selCats );
			foreach( $selCats as $cid ) {
				if( isset( $categories[ $cid ] ) )
					$allCats += (array) $categories[ $cid ][ 'sub_cats' ];
			}
			$this->categories = $allCats;

			// populate data for this feature in each product
			foreach( $this->items as $p )
				$feature_data[ $p ] = get_post_meta( $p, 'compare_product_data', true );

			foreach( $allCats as $cid => $cat ) {
				$this->data[ $cid ] = array();
				foreach( $cat['features'] as $fid => $feat ) {
					foreach( $feature_data as $pid => $dat ) {
						if( isset( $dat[ $cid ][ $fid ] ) )
							$this->data[ $cid ][ $fid ][ $pid ] = $dat[ $cid ][ $fid ];
					}
				}
			}
		}


		/**
		 * Output table
		 */
		function display( $single = false ) {
			$GLOBALS['be_compare_disable_table_link'] = true;
			$features = get_option( 'be_compare_features' );
			$attributes = wc_get_attribute_taxonomies();
			$cols = count( $this->items ) + 1;
			$background_url = WC()->plugin_url() . "/assets/images/chosen-sprite.png";

			ob_start();
			?>
			<p class="print-link"><a href="javascript:print();"><?php _e( 'Print', 'be-compare-products' ); ?></a></p>
			<table id="be_compare_features_table" class="be_compare_features_table products">
				<?php if( !$single ) : ?>
					<thead>
					<th>&nbsp;</th>
					<?php foreach( $this->items as $pid ) : $product = wc_get_product( $pid ); ?>
						<th product-id="<?php echo $pid; ?>" class="product">
							<div class="compare-product-remove" style="background-image: url(<?php echo $background_url; ?>);"></div>
							<?php $p =  wc_get_product( $pid ); if( has_post_thumbnail( $pid ) ) echo get_the_post_thumbnail( $pid, 'thumbnail' ); ?>
							<h4><?php echo get_the_title( $pid ); ?></h4>
							<?php echo $p->get_rating_html(); ?>
							<?php echo do_shortcode( '[add_to_cart id="' . $pid . '" style="text-align:center;"]' ); ?>
						</th>
					<?php endforeach; ?>
					</thead>
				<?php endif; ?>
				<tbody>
				<?php uasort( $this->categories, array( &$this, 'usort_reorder' ) ); $i = 1; foreach( $this->categories as $cid => $cat ) : ?>
					<tr class="subcategory <?php if( $i % 2 == 0 ) echo "alternate"; ?>">
						<td colspan="<?php echo $cols; ?>"><?php echo $cat[ 'title' ]; ?>
						</td>
					</tr>
					<?php uasort( $cat['features'], array( &$this, 'usort_reorder' ) ); $i = 1; foreach( $cat[ 'features' ] as $fid => $feat ) : ?>
						<tr <?php if( $i % 2 !== 0 ) echo 'class="alternate"'; ?>>
							<?php
							// woocommerce attribute information
							if( strstr( $fid, 'attr_' ) ) {
								$temp = 1;
								$attr_id = str_replace( 'attr_', '', $fid, $temp );
								$result = array_search( $attr_id, array_map( array( $this, 'map_attribute_id' ), $attributes ) );

								// proceed if attribute is found
								if( $result !== false ) {
									$feature_title = $attributes[ $result ]->attribute_label;
								}
								// custom feature information
							} else
								$feature_title = $features[ $fid ][ 'title' ];
							?>
							<th><?php echo $feature_title; ?></th>
							<?php foreach( $this->items as $pid ) : ?>
								<?php
								if( strstr( $fid, 'attr_' ) ) {
									// proceed if attribute is found
									if( $result !== false ) {
										$product = wc_get_product( $pid );
										$terms = get_the_terms( $product->id, 'pa_' . $attributes[ $result ]->attribute_name );
										if( is_array( $terms ) )
											$feature_specs = array_map( array( $this, 'map_attribute_name' ), $terms );
										else $feature_specs = '';
									}
									// custom feature information
								} else
									$feature_specs = $this->data[ $cid ][ $fid ][ $pid ];
								?>
								<td><?php if( isset( $feature_specs ) ) :
										if( is_array( $feature_specs ) )
											echo apply_filters( 'be_compare_table_product_value', implode( ', ', $feature_specs ) );
										else
											echo apply_filters( 'be_compare_table_product_value', $feature_specs );
									endif; ?></td>
							<?php endforeach; ?>
						</tr>
						<?php $i++; endforeach; ?>
					<?php $i++; endforeach; ?>
				</tbody>
				<?php if( !$single ) : ?>
					<tfoot>
					<th>&nbsp;</th>
					<?php foreach( $this->items as $pid ) : $product = wc_get_product( $pid ); ?>
						<th>
							<p><a href="<?php echo $product->get_permalink(); ?>"><?php echo  $product->get_title(); ?></a></p>
							<?php echo do_shortcode( '[add_to_cart id="' . $pid . '" style="text-align:center;"]' ); ?>
						</th>
					<?php endforeach; ?>
					</tfoot>
				<?php endif; ?>
			</table>
			<?php
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}


		/**
		 * ��������� �������
		 */
		function display_short( ) {
			$GLOBALS['be_compare_disable_table_link'] = true;
			$features = get_option( 'be_compare_features' );
			$attributes = wc_get_attribute_taxonomies();
			$cols = count( $this->items ) + 1;

			//$background_url = WC()->plugin_url() . "/assets/images/chosen-sprite.png";
			$a = 1;
			//ob_start();
			?>
			<table id="be_compare_features_table" class="be_compare_features_table products">
				<tbody>
				<?php uasort( $this->categories, array( &$this, 'usort_reorder' ) ); foreach( $this->categories as $cid => $cat ) : ?>
					<?php uasort( $cat['features'], array( &$this, 'usort_reorder' ) ); $i = 1; foreach( $cat[ 'features' ] as $fid => $feat ) :
						if($a>10) break; ?>
						<tr>
							<?php
//echo '||' . $i;
							// woocommerce attribute information
							if( strstr( $fid, 'attr_' ) ) {
								$temp =1;
								$attr_id = str_replace( 'attr_', '', $fid, $temp );
								$result = array_search( $attr_id, array_map( array( $this, 'map_attribute_id' ), $attributes ) );

								// proceed if attribute is found
								if( $result !== false ) {
									$feature_title = $attributes[ $result ]->attribute_label;
								}
								// custom feature information
							} else
								$feature_title = $features[ $fid ][ 'title' ];
							?>
							<th><?php echo $feature_title; ?></th>
							<?php foreach( $this->items as $pid ) : ?>
								<?php
								if( strstr( $fid, 'attr_' ) ) {
									// proceed if attribute is found
									if( $result !== false ) {
										$product = wc_get_product( $pid );
										$terms = get_the_terms( $product->id, 'pa_' . $attributes[ $result ]->attribute_name );
										if( is_array( $terms ) )
											$feature_specs = array_map( array( $this, 'map_attribute_name' ), $terms );
										else $feature_specs = '';
									}
									// custom feature information
								} else
									$feature_specs = $this->data[ $cid ][ $fid ][ $pid ];
								?>
								<td><?php if( isset( $feature_specs ) ) :
										if( is_array( $feature_specs ) )
											echo apply_filters( 'be_compare_table_product_value', implode( ', ', $feature_specs ) );
										else
											echo apply_filters( 'be_compare_table_product_value', $feature_specs );
									endif; ?></td>
							<?php
							endforeach; ?>
						</tr>
						<?php $a++; $i++; endforeach; ?>
					<?php  endforeach; ?>
				</tbody>
			</table>
			<?php
			//$output = ob_get_contents();
			//ob_end_clean();

			//return $output;
		}


		/**
		 * array_map function to return attribute_id
		 */
		function map_attribute_id( $element ){ return $element->attribute_id; }


		/**
		 * array_map function to return element name
		 */
		function map_attribute_name( $element ){ return $element->name; }


		/**
		 * add shortcode to display table
		 */
		function compare_table_shortcode( $atts ) {

			$products = array();
			if( isset( $atts[ 'products' ] ) )
				$products = explode( ',', $atts[ 'products' ] );

			$this->prepare_items( $products );

			return $this->display();
		}



	}

	return new BE_Compare_Tables();

endif;

?>