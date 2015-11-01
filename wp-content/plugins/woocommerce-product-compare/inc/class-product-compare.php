<?php
/**
 * Bolder Compare Products Settings Class.
 *
 * @author 		Bolder Elements
 * @category 	Inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'BE_Compare_Products' ) ) :

/**
 * BE_Compare_Settings
 */
class BE_Compare_Products {

	/**
	 * Constructor.
	 */
	public function __construct() {

		// Check if disabled on mobile devices
		$disable_mobile = BE_Compare_Settings::get_option( 'be_compare_hide_mobile' );
		if( $disable_mobile == 'yes' && wp_is_mobile() ) return;

		add_action( 'init', array( &$this, 'open_session' ), 1 );
		add_action( 'wp_logout', array( &$this, 'close_session' ) );

		// Determine position of preview box
		$preview_loc = BE_Compare_Settings::get_option( 'be_compare_preview_location' );
		switch( $preview_loc ) {
			case 'page-bottom':
				add_action( 'woocommerce_after_shop_loop', array( &$this, 'output_basket' ), 5 );
				break;
			case 'no-show':
				break;
			case 'page-top':
			default:
				add_action( 'woocommerce_before_shop_loop', array( &$this, 'output_basket' ), 5 );
				break;
		}

		// If disabled on shop page
		if( BE_Compare_Settings::get_option( 'be_compare_button_visibility' ) != 'only-single' )
			add_action( 'woocommerce_after_shop_loop_item', array( &$this, 'display_button' ), 5 );
		add_action( 'woocommerce_before_single_product', array( $this, 'determine_button_location' ) );
		add_action( 'wp_footer', array( $this, 'add_script_frontend' ) );
		add_filter( 'woocommerce_product_tabs', array( $this, 'new_product_tab' ) );

		// AJAX functions
		add_action( 'wp_ajax_be_compare_add_product', array( $this, 'add_product' ) );
		add_action( 'wp_ajax_nopriv_be_compare_add_product', array( $this, 'add_product' ) );
		add_action( 'wp_ajax_be_compare_update_basket', array( $this, 'update_basket' ) );
		add_action( 'wp_ajax_nopriv_be_compare_update_basket', array( $this, 'update_basket' ) );
		add_action( 'wp_ajax_be_compare_empty_basket', array( $this, 'empty_product_basket' ) );
		add_action( 'wp_ajax_nopriv_be_compare_empty_basket', array( $this, 'empty_product_basket' ) );
		add_action( 'wp_ajax_be_compare_reset_box', array( $this, 'reset_compare_box' ) );
		add_action( 'wp_ajax_nopriv_be_compare_reset_box', array( $this, 'reset_compare_box' ) );
		//add_action( 'wp_ajax_be_compare_add_message', array( $this, 'add_message' ) );
		//add_action( 'wp_ajax_nopriv_be_compare_add_message', array( $this, 'add_message' ) );

	}


	/**
	 * Display compare button on shop and single product pages
	 */
	function display_button( $product_id = "", $reset = false ) {
		global $product, $be_compare_disable_table_link;

		// if viewing the listing in the product compare table
		if( $be_compare_disable_table_link ) return;

		// retrieve product ID if executed via AJAX
		$pid = ( empty( $product_id ) ) ? $product->id : (int) $product_id;
		$enabled = sanitize_title( get_post_meta( $pid, 'enable_compare_product', true ) );
		$category = sanitize_title( get_post_meta( $pid, 'selcat_compare_product', true ) );

		if( $enabled != 'yes' ) return;
		if( !$category || empty( $category ) ) return;

		if( isset( $_SESSION[ 'be_compare_products' ] ) && count( $_SESSION[ 'be_compare_products' ] ) && in_array( $pid, $_SESSION[ 'be_compare_products' ] ) && $reset == false ) {
?>
		<div id="compare-link-<?php echo $pid; ?>" product-id="<?php echo $pid; ?>" class="compare-product-link">
			<input type="checkbox" checked="checked" /> <?php echo '<input type="button" class="compare-products-button" value="' . __( 'Compare', 'be-compare-products' ) . '" />'; ?>
		</div>
<?php
		} else {
?>
		<div id="compare-link-<?php echo $pid; ?>" product-id="<?php echo $pid; ?>" class="compare-product-link">
			<input type="checkbox" id="compare-checkbox-<?php echo $pid; ?>" /> <label for="compare-checkbox-<?php echo $pid; ?>"><?php _e( 'Add to Compare', 'be-compare-products' ); ?></label>
		</div>
<?php
		}

	}


	/**
	 * determine location for button on single product pages
	 */
	function determine_button_location() {
		global $product;

		if( BE_Compare_Settings::get_option( 'be_compare_button_visibility' ) == 'only-shop' )
			return;

		if( !is_admin() ) :
			switch ( sanitize_title( BE_Compare_Settings::get_option( 'be_compare_button_location' ) ) ) {
				case 'after-title':
					$hook_index = 8;
					break;
				case 'after-price':
					$hook_index = 15;
					break;
				case 'after-summary':
					$hook_index = 25;
					break;
				case 'after-categories':
				default:
					$hook_index = 45;
					break;
			}
			add_action( 'woocommerce_single_product_summary', array( &$this, 'display_button' ), $hook_index );

		endif;
	}


	/**
	 * Add product to basket
	 */
	function add_product() {

		$product_id = (int) $_POST[ 'product' ];
		$max_items = (int) BE_Compare_Settings::get_option( 'be_compare_compare_limit' );
		$current_number = ( isset( $_SESSION[ 'be_compare_products' ] ) && is_array( $_SESSION[ 'be_compare_products' ] ) ) ? count( $_SESSION[ 'be_compare_products' ] ) : 0;

		if( is_array( $_SESSION[ 'be_compare_products' ] ) && in_array( $product_id, $_SESSION[ 'be_compare_products' ] ) )
			unset( $_SESSION[ 'be_compare_products' ][ array_search( $product_id, $_SESSION[ 'be_compare_products' ] ) ] );
		elseif( $current_number < $max_items )
			$_SESSION[ 'be_compare_products' ][] = $product_id;

		$_SESSION[ 'be_compare_products' ] = array_unique( $_SESSION[ 'be_compare_products' ] );
		$this->display_button( $product_id );

		die();
	}


	/**
	 * Empty all products from basket
	 */
	function empty_product_basket() {

		$_SESSION[ 'be_compare_products' ] = array();
		$this->update_basket();

	}


	/**
	 * Reset compare boxes after product basket emptied
	 */
	function reset_compare_box() {

		$product_id = (int) $_POST[ 'product' ];
		$this->display_button( $product_id, true );
	}


	/**
	 * Display preview box containing currently selected products
	 */
	function output_basket() {
		$max_set = (int) BE_Compare_Settings::get_option( 'be_compare_compare_limit' );
		$current = count( $_SESSION[ 'be_compare_products' ] );
?>
		<div id="compare-products-messages"></div>
		<div id="compare-products-basket">

	<?php if( isset( $_SESSION[ 'be_compare_products' ] ) && count( $_SESSION[ 'be_compare_products' ] ) ) : ?>
			<p class="compare-clear-items"><a href="#"><?php _e( 'Clear All', 'be-compare-products' ); ?></a></p>
			
			<div class="compare-products-basket-inner">

		<?php foreach( $_SESSION[ 'be_compare_products' ] as $key ) : ?>
			<?php if( $key != 0 ) : ?>

			<div class="compare-product" product-id="<?php echo $key; ?>">
				<?php echo get_the_post_thumbnail( (double) $key, 'thumbnail', array( 'class' => 'compare-product-img' ) ); ?>
				<a href="#" class="compare-product-remove"></a>
			</div>
			
			<?php endif; ?>
		<?php endforeach; ?>

		<?php if( $current < $max_set ) : ?>
			<?php for( $i = $current; $i < $max_set; $i++ ) : ?>
				<div class="compare-product-placeholder"></div>
			<?php endfor; ?>
		<?php endif; ?>

				<input type="button" class="compare-products-button basket" value="<?php _e( 'Compare', 'be-compare-products' ); ?>" />

			</div>
	<?php endif; ?>

		</div>
<?php
	}


	/**
	 * Update the preview box after an item is added / removed
	 */
	function update_basket() {

		$this->output_basket();
		die();
	}


	/**
	 * Show error message if applies
	 */
	function add_message() {

		$max_items = (int) BE_Compare_Settings::get_option( 'be_compare_compare_limit' );
		$current_number = ( isset( $_SESSION[ 'be_compare_products' ] ) && is_array( $_SESSION[ 'be_compare_products' ] ) ) ? count( $_SESSION[ 'be_compare_products' ] ) : 0;

		if( $max - $current_number < 0 ) :
?>
			<div class="compare-products-error">
				<p><?php _e( 'You may not compare more than ' . $max_items . ' products at one time', 'be-compare-products' ); ?>.</p>
			</div>
<?php
		endif;

		die();
	}


	/**
	 * Open new session for compare products
	 */
	function open_session() {

		if( !session_id() ) {
			// open session to begin storing comparable products
			session_start();
			if( !isset( $_SESSION[ 'be_compare_starttime' ] ) ) $_SESSION[ 'be_compare_starttime' ] = time();
			if( !isset( $_SESSION[ 'be_compare_products' ] ) ) $_SESSION[ 'be_compare_products' ] = array();
		}
		if( isset( $_SESSION[ 'be_compare_starttime' ] ) ) {
			//if session has been alive for more than 24 hours, empty compare basket
			if( (int) $_SESSION[ 'be_compare_starttime' ] > time() + 86400 ){
				unset( $_SESSION[ 'be_compare_products' ] );
			}
		}

	}


	/**
	 * Close session for compare products
	 */
	function close_session() {

		if( isset( $_SESSION ) )
			session_destroy();

	}


	/**
	 * Вкладка спецификация
	 */
	function new_product_tab( $tabs ) {
		global $post;

		$tab_enabled = BE_Compare_Settings::get_option( 'be_compare_features_enabled' );
		$product_enabled = get_post_meta( $post->ID, 'enable_compare_product', true );
		
		if( $tab_enabled == 'yes' && $product_enabled == 'yes' ) {
			// determine tab's position
			switch ( sanitize_title( BE_Compare_Settings::get_option( 'be_compare_features_location' ) ) ) {
				case 'before-desc':
					$hook_index = 5;
					break;
				case 'before-additional':
					$hook_index = 15;
					break;
				case 'before-reviews':
					$hook_index = 25;
					break;
				case 'after-reviews':
				default:
					$hook_index = 35;
					break;
			}

			// Adds the new tab
			$tabs['features'] = array(
				'title' 	=> __( BE_Compare_Settings::get_option( 'be_compare_features_title' ), 'be-compare-products' ),
				'priority' 	=> $hook_index,
				'callback' 	=> array( $this, 'new_product_tab_content')
			);
		}
	 
		return $tabs;
	 
	}

	//Вывод контента во вкладку продукт;
	function new_product_tab_content() {
		global $product;
	 
		$featuresTable = new BE_Compare_Tables();
		$featuresTable->prepare_items( array( $product->id ) );
		echo $featuresTable->display( true );
		
	}

	//Вывод контента во вкладку продукт анонс;
	function new_product_tab_content_short() {
		global $product;

		$featuresTable = new BE_Compare_Tables();
		$featuresTable->prepare_items( array( $product->id ) );
		echo $featuresTable->display_short( true );

	}


	/**
	 * Add Script Directly to Dashboard Foot
	 */
	public function add_script_frontend() {
		// Setup params
		$compare_button_link	= __( 'Please Enter a Title for this Category', 'be-compare-products' );
?>
<script type='text/javascript'>
/* <![CDATA[ */
var be_compare_params = {"compare_button_url":"<?php echo addcslashes( get_permalink( get_option( 'be_compare_page' ) ), '/' ); ?>","text_add_compare":"<?php _e( 'Add to Compare', 'be-compare-products' ); ?>"};
/* ]]> */
</script>
<?php
	}
}

return new BE_Compare_Products();

endif;

?>