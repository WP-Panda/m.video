<?php
/*
Plugin Name: WooCommerce Product Comparison
Plugin URI: http://bolderelements.net/plugins/compare-products-woocommerce/
Description: Create tables describing further details of your shop items, and allow customers to view them side by side for comparison
Author: Bolder Elements
Author URI: http://www.bolderelements.net/
Version: 1.3

	Copyright: © 2014-2015 Bolder Elements (email : info@bolderelements.net)
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

// Current version
if ( ! defined( 'BE_WooProductCompare_VERSION' ) ) define( 'BE_WooProductCompare_VERSION', '1.3' );

add_action('plugins_loaded', 'be_woocommerce_compare_init', 100);
function be_woocommerce_compare_init() {

	/**
	 * Check if WooCommerce is active
	 */
	if ( class_exists( 'woocommerce' ) || class_exists( 'WooCommerce' ) ) {

		if ( !class_exists( 'BE_Product_Compare_WC' ) ) {

			// setup internationalization support
			load_plugin_textdomain('be-compare-products', false, 'woocommerce-product-compare/languages');

			if( !isset( $woocommerce ) )
				$woocommerce = WC();

			class BE_Product_Compare_WC {

				/**
				 * __construct function.
				 *
				 * @access public
				 * @return void
				 */
				function __construct() {
					$this->id = 'be_compare_products';
					$this->version = '1.3';
					$this->admin_page_heading = __('Compare Products', 'be-compare-products' );
					$this->admin_page_description = __( 'Setup categories of products with similar to features to display a comparison table', 'be-compare-products' );

					// Include required files
					if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {
						$this->frontend_includes();
					} elseif( is_admin() ) {
						// Admin only includes
						add_action( 'admin_menu', array( $this, 'settings_page' ), 52 );
						add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'compare_products_tab' ) );
						add_action( 'woocommerce_product_write_panels', array( $this, 'compare_tab_options' ) );
						add_action( 'woocommerce_process_product_meta', array( $this, 'process_product_meta_compare_tab' ), 10, 2);
						add_action( 'save_post', array( $this, 'process_product_meta_compare_tab' ) );
						add_action( 'quick_edit_custom_box',  array( $this, 'quick_edit_data' ), 10, 2 );
						//add_action( 'woocommerce_product_quick_edit_end', array( $this, 'enable_compare_product_quick' ) );
						add_action( 'woocommerce_product_bulk_edit_end', array( $this, 'enable_compare_product_quick') );
						add_action( 'admin_enqueue_scripts', array( $this, 'register_plugin_admin' ) );
						add_action( 'admin_footer', array( $this, 'add_script_admin' ) );
					}
					if( !is_admin() ) {
						add_shortcode( 'compare_table', array( BE_Compare_Tables::get_instance(), 'compare_table_shortcode' ) );
					}

					add_action( 'init', array( $this, 'includes' ) );
					add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
					add_filter( 'woocommerce_screen_ids', array( $this, 'add_settings_screen' ) );

				}


				/**
				 * includes function
				 */
				function includes() {

					if ( ! is_ajax() ) {
						include_once( WC()->plugin_path() . '/includes/admin/class-wc-admin-assets.php' );
					} elseif( is_ajax() && is_admin() ) {
						// Add files required for AJAX calls by this plugin
						include_once( WC()->plugin_path() . '/includes/admin/settings/class-wc-settings-page.php' );
						require_once( 'inc/class-settings-categories.php' );
						require_once( 'inc/class-settings-products.php' );
					}
				}


				/**
				 * frontend_includes function
				 */
				function frontend_includes() {

					require_once( 'inc/class-settings.php' );
					require_once( 'inc/class-product-compare.php' );
					require_once( 'inc/class-compare-tables.php' );
				}


				/**
				 * add settings page to menu
				 */
				public function settings_page() {
					add_submenu_page( 'woocommerce', __( 'Compare Products', 'be-compare-products' ),  __( 'Compare Products', 'be-compare-products' ) , 'manage_woocommerce', 'be-compare-products', array( $this, 'display_settings' ) );
				}


				/**
				 * initialize settings page content
				 */
				public function display_settings() {
					include_once( WC()->plugin_path() . '/includes/admin/class-wc-admin-settings.php' );
					include_once( 'inc/class-settings.php' );
					BE_Compare_Settings::output();
				}


				/**
				 * add settings page to list of WC settings
				 */
				public function add_settings_screen( $current_screens ) {
					$wc_screen_id = sanitize_title( strtolower( __( 'WooCommerce', 'woocommerce' ) ) );

					$current_screens[] = $wc_screen_id . '_page_be-compare-products';
					return $current_screens;
				}


				/**
				 * Add javascript functions to frontend
				 */
				public function register_plugin_styles() {
					wp_enqueue_script( 'be_compare_frontend_js', plugins_url( 'assets/js/frontend.js', __FILE__ ), array( 'jquery' ), '1.0', true );
					wp_enqueue_script( 'be_compare_stickyheader', plugins_url( 'assets/js/jquery.stickyheader.js', __FILE__ ), array( 'jquery' ), '1.0', true );
					wp_enqueue_style( 'be_compare_frontend_css', plugins_url( 'assets/css/frontend.css', __FILE__ ), '1.0', true );
				}


				/**
				 * Modify Scripts in Dashboard
				 */
				public function register_plugin_admin( $hook_suffix ) {
					wp_enqueue_script( 'be_compare_dashboard_js', plugins_url( 'assets/js/dashboard.js', __FILE__ ), array( 'jquery' ), '1.0', true );
					wp_enqueue_style( 'be_compare_dashboard_css', plugins_url( 'assets/css/dashboard.css', __FILE__ ), '1.0', true );
				}


				/**
				 * Add Script Directly to Dashboard Foot
				 */
				public function add_script_admin() {

					// Setup translated strings
					$text_new_cat 		= __( 'Please Enter a Title for this Category', 'be-compare-products' );
					$text_new_cat_desc 	= __( 'The title will not be seen to the user but used when setting up product features', 'be-compare-products' );
					$text_del_cat 		= __( 'Are you sure you want to delete this category and all of its subcategories and features', 'be-compare-products' );
					$text_del_cat_desc 	= __( 'This action CANNOT be undone', 'be-compare-products' );
					$text_new_sub 		= __( 'Please Enter a Title for this Subcategory', 'be-compare-products' );
					$text_new_sub_desc 	= __( 'This title will appear in the compare table above any features assigned to it', 'be-compare-products' );
					$text_del_sub 		= __( 'Are you sure you want to delete this subcategory and all of its features', 'be-compare-products' );
					$text_new_feat 		= __( 'Add a Feature', 'be-compare-products' );
					$text_new_feat_sel 	= __( 'Select an existing feature', 'be-compare-products' );
					$text_new_feat_new 	= __( 'Or create a new one', 'be-compare-products' );
					$text_feat_title 	= __( 'Feature Title', 'be-compare-products' );
					$text_feat_type 	= __( 'Input Type', 'be-compare-products' );
					$text_feat_ops	 	= __( 'Input Options', 'be-compare-products' );
					$text_edit_feat 	= __( 'Edit Feature', 'be-compare-products' );
					$text_rem_feat 		= __( 'Are you sure you want to remove the feature from this subcategory', 'be-compare-products' );
					$text_del_feat 		= __( 'Are you sure you want to delete this feature', 'be-compare-products' );
					$text_del_feats		= __( 'Are you sure you want to delete these features', 'be-compare-products' );
					$text_add_new 		= __( 'Add New', 'be-compare-products' );
					$text_edit	 		= __( 'Edit', 'be-compare-products' );
					$text_cancel 		= __( 'Cancel', 'be-compare-products' );
					$text_delete 		= __( 'Delete', 'be-compare-products' );
					$text_go 			= __( 'Go', 'be-compare-products' );
					$text_active 		= __( 'Active', 'be-compare-products' );
					$text_inactive		= __( 'Inactive', 'be-compare-products' );
					?>
					<script type='text/javascript'>
						/* <![CDATA[ */
						var be_compare_input_type = {"text-input":"Text - Single Line Entries","text-area":"Textarea - Multiple Line Entries","bool":"Boolean - Yes or No Questions","single-select":"Select - Choose One From a List","multi-select":"Checkbox - Select One or More From List"}
						var be_compare_data = {"ajax_url":"<?php echo addcslashes( admin_url( 'admin-ajax.php', 'relative' ), '/' ); ?>","ajax_loader_url":"<?php echo addcslashes( plugins_url( 'assets/img/loader.gif', __FILE__ ), '/' ); ?>","text_new_category":"<?php echo $text_new_cat; ?>","text_new_category_desc":"<?php echo $text_new_cat_desc; ?>","text_new_subcategory":"<?php echo $text_new_sub; ?>","text_new_subcategory_desc":"<?php echo $text_new_sub_desc; ?>","text_del_category":"<?php echo $text_del_cat; ?>","text_del_category_desc":"<?php echo $text_del_cat_desc; ?>","text_del_subcategory":"<?php echo $text_del_sub; ?>","text_add_new":"<?php echo $text_add_new; ?>","text_edit":"<?php echo $text_edit; ?>","text_cancel":"<?php echo $text_cancel; ?>","text_delete":"<?php echo $text_delete; ?>","text_go":"<?php echo $text_go; ?>","text_new_feature":"<?php echo $text_new_feat; ?>","text_new_feature_sel":"<?php echo $text_new_feat_sel; ?>","text_new_feature_new":"<?php echo $text_new_feat_new; ?>","text_feature_title":"<?php echo $text_feat_title; ?>","text_feature_type":"<?php echo $text_feat_type; ?>","text_feature_ops":"<?php echo $text_feat_ops; ?>","text_edit_feature":"<?php echo $text_edit_feat; ?>","text_rem_feature":"<?php echo $text_rem_feat; ?>","text_del_feature":"<?php echo $text_del_feat; ?>","text_del_features":"<?php echo $text_del_feats; ?>","text_active":"<?php echo $text_active; ?>","text_inactive":"<?php echo $text_inactive; ?>"};
						/* ]]> */
					</script>
					<?php
				}


				function quick_edit_data() {
					?>
					<div id="">
					</div>
					<?php
				}


				function enable_compare_product_quick() {

					$options = '';
					$features = get_option( 'be_compare_categories' );
					if( $features )
						foreach( $features as $key => $val )
							$options .= '<option value="' . $key . '">' . $val[ 'title' ] . '</option>';
					?>
					<br class="clear" />
					<label class="alignleft">
						<span class="title">Compare</span>
						<span class="input-text-wrap"><input type="checkbox" name="enable_compare_product" class="enable_compare_product" value="yes" <?php echo $selected; ?> /> Enable ability to compare this product</span>
					</label>
					<br class="clear" />
					<label class="alignleft">
						<span class="title">Category</span>
						<span class="input-text-wrap"><select class="selcat_compare_product" name="selcat_compare_product"><?php echo $options; ?></select> For comparing purposes only</span>
					</label>
					<?php
				}


				function compare_products_tab() {
					?>
					<li class="compare_products"><a href="#compare_products_data"><?php _e('Compare', 'be-compare-products'); ?></a></li>
					<?php
				}


				function compare_tab_options() {
					global $post;

					$compare_tab_options = array(
						'enable_compare_product' => get_post_meta( $post->ID, 'enable_compare_product', true ),
						'selcat_compare_product' => get_post_meta( $post->ID, 'selcat_compare_product', true ),
					);

					$display = ( $compare_tab_options[ 'enable_compare_product' ] == 'yes' ) ? "" : "hidden";

					$catOps = array();
					$features = get_option( 'be_compare_categories' );
					if( $features )
						foreach( $features as $key => $val )
							$catOps[ $key ] = $val[ 'title' ];
					?>
					<div id="compare_products_data" class="panel woocommerce_options_panel">
						<div class="options_group">

							<?php
							echo '<pre>';
							print_r($_POST);
							echo '</pre>';


							$array = array();
							foreach ( $_POST as $key => $val ) {
								if( substr( $key,'cr_param_' ) ) {
									$array[$key] = $val;
								}
							}
							echo '<pre>';
							print_r($array);
							echo '</pre>';
							//				$custom_fields = get_post_meta($post->ID);
							//				foreach ( $custom_fields as $key => $value )
							//					echo '<pre>' . $key . ' => ';
							//						var_dump( $value );
							//					echo '</pre>';
							//print_r($custom_fields);
							?>

							<p>
								<?php woocommerce_wp_checkbox(
									array(
										'id' => 'enable_compare_product',
										'class' => 'checkbox',
										'label' => __( 'Enable Product Compare', 'be-compare-products' ),
										'description' => __( 'Enable the ability to compare this item to other products', 'be-compare-products' )
									)
								); ?>
							</p>
							<?php woocommerce_wp_select(
								array( 'id' => 'selcat_compare_product',
									'class' => 'select short',
									'wrapper_class' => $display,
									'label' => __( 'Select Compare Category', 'be-compare-products' ),
									'options' => $catOps ) ); ?>

							<select name="comp_category" id="comp_category" data-id="<?php echo $post->ID; ?>">
								<option>Select a category to view more options</option>
								<option value="cr_par_cat_16f2c83f">Наушники</option>
							</select>

							<div class="labeled-form">
							</div>
							<a href="#" class="compare-product-edit" data-id="<?php echo $post->ID; ?>" data-title="<?php echo $post->post_title; ?>">Edit</a>
						</div>


					</div>
					<script type="text/javascript">
						jQuery(document).ready(function($) {
							jQuery('#enable_compare_product').live('change', function(e){
								var selectBox = jQuery( this ).parent().parent().find( '.selcat_compare_product_field' );

								if( selectBox.hasClass( 'hidden' ) )
									selectBox.removeClass( 'hidden' );
								else
									selectBox.addClass( 'hidden' );
							});
						});
					</script>
					<?php
				}


				/**
				 * Processes the compare tab options when a post is saved
				 */
				function process_product_meta_compare_tab( $post_id ) {

					// verify if this is an auto save routine.
					if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
						return $post_id;

					if( !isset( $_REQUEST['post_type'] ) )
						return $post_id;

					$postType = sanitize_title( $_REQUEST['post_type'] );
					$enable_compare_product = sanitize_title( $_REQUEST['enable_compare_product'] );
					$selcat_compare_product = sanitize_title( $_REQUEST['selcat_compare_product'] );

					// Only save for product post types
					if( 'product' == $postType ) {

						update_post_meta( $post_id, 'enable_compare_product', ( isset( $enable_compare_product ) && $enable_compare_product ) ? 'yes' : 'no' );
						update_post_meta( $post_id, 'selcat_compare_product', $selcat_compare_product );
					}

					$array = array();
					foreach ( $_POST as $key => $val ) {
						if( substr( $key,'cr_param_' ) ) {
							$array[$key] = $val;
						}
					}

					if( !empty($array) ) {

						$fields = array();

						foreach( $array as $k1 => $v1 ) {
							foreach ( $v1 as $k2 => $v2 ) {
								if( is_array( $v2 ) ) {
									foreach ( $v2 as $k3 => $v3 ) {
										$fields[ $k1 ][ $k2 ][ $k3 ] = wp_kses_data( $v3 );
									}
								} else
									$fields[ $k1 ][ $k2 ] = wp_kses_data( $v2 );
							}
						}

						update_post_meta( $post_id, 'compare_product_data', $fields );
					}

				}

			}

			new BE_Product_Compare_WC();
		}
	}
}

/**
 * Modify links on plugin listing page (Left, Network Included)
 *
 * @access public
 * @return void
 */
function be_product_compare_wc_action_links( $links ) {
	return array_merge(
		array(
			'settings' => '<a href="' . get_admin_url() . 'admin.php?page=be-compare-products">' . __( 'Settings', 'be-compare-products' ) . '</a>',
			'register' => '<a href="' . get_admin_url() . 'admin.php?page=be-manage-plugins">' . __( 'Registration', 'be-compare-products' ) . '</a>',
		),
		$links
	);
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'be_product_compare_wc_action_links' );

function be_product_compare_wc_network_action_links( $links ) {
	return array_merge(
		array(
			'register' => '<a href="' . get_admin_url() . 'admin.php?page=be-manage-plugins">' . __( 'Registration', 'be-compare-products' ) . '</a>',
		),
		$links
	);
}
add_filter( 'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ), 'be_product_compare_wc_network_action_links' );


/**
 * Modify links on plugin listing page (Right)
 *
 * @access public
 * @return array
 */
function be_product_compare_wc_plugin_meta( $links, $file ) {

	if ( $file == plugin_basename( __FILE__ ) ) {

		// Check if plugin already has a 'View details' link
		$index = 'details';
		foreach( $links as $key => $value )
			if( strstr( $value, 'View details' ) )
				$index = $key;

		$row_meta = array(
			$index 	  => '<a href="' . network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=woocommerce-product-compare&TB_iframe=true&width=600&height=550' ) . '" class="thickbox">' . __( 'View details', 'be-compare-products' ) . '</a>',
			'docs'    => '<a href="http://bolderelements.net/docs/woocommerce-product-compare/">' . __( 'Docs', 'be-compare-products' ) . '</a>',
			'support' => '<a href="http://bolderelements.net/support/" target="_blank">' . __( 'Support', 'be-compare-products' ) . '</a>'
		);
		return ( $links + $row_meta );
	}
	return (array) $links;
}
add_filter( 'plugin_row_meta', 'be_product_compare_wc_plugin_meta', 10, 2 );


/**
 * Initialise Auto Update Features
 *
 * @access public
 * @return void
 */
add_action( 'init', 'Updater_WooProductCompare' );
function Updater_WooProductCompare() {
	include_once( 'upgrader/class-be-config.php' );

	if( class_exists( 'BolderElements_Plugin_Updater' ) )
		new BolderElements_Plugin_Updater( __FILE__, BE_WooProductCompare_VERSION, '9009678', 'woocommerce-product-compare', 'WooCommerce Product Comparison' );
}

?>