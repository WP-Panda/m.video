<?php
/**
 * Bolder Compare Products Categories Settings Class.
 *
 * @author 		Bolder Elements
 * @category 	Inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'BE_Compare_Settings_Products' ) ) :

/**
 * BE_Compare_Settings
 */
class BE_Compare_Settings_Products extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id    = 'products';
		$this->label = __( 'Products', 'be-compare-products' );

		require_once( 'class-table-products.php' );

		add_filter( 'be_compare_settings_tabs_array', array( $this, 'add_settings_page' ), 30 );
		add_action( 'be_compare_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'be_compare_settings_save_' . $this->id, array( $this, 'save' ) );
		add_action( 'be_compare_settings_tabs_categories', array( &$this, 'output' ) );
		add_action( 'be_compare_sections_' . $this->id, array( $this, 'output_sections' ) );

		// AJAX functions
		add_action( 'wp_ajax_be_compare_edit_product_form', array( &$this, 'edit_product_form' ) );
		add_action( 'wp_ajax_be_compare_edit_product_update', array( &$this, 'update_product_form' ) );

		/**
		 * Сохранение параметров ппродукта в модальномс окне вызов
		 */
		add_action( 'wp_ajax_be_compare_edit_product_save', array( &$this, 'save_product_form' ) );
	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {

		return apply_filters( 'be_compare_settings_categories', array(

			array( 
				'title' => __( 'Compare Products', 'be-compare-products' ), 
				'type' => 'title', 
				'desc' => __( 'Below is a list of currently enabled products. These products have the ability to be compared, however you can still disable them below to temporarily hide this feature from its options.', 'be-compare-products' ), 
				'id' => 'product_options'
			),

			array( 'type' => 'sectionend', 'id' => 'product_options'),

		) );
	}


	/**
	 * No settings to save
	 */
	public function save() { }


	/**
	 * Output the settings
	 */
	public function output() {
		global $current_section;

		if( $current_section == '' ) $GLOBALS['hide_save_button'] = true;

		$settings = $this->get_settings( $current_section );
		WC_Admin_Settings::output_fields( $settings );

		$this->show_table_products();
	}


	/**
	 * Save settings
	 */
	public function show_table_products() {
?>
	<div id="compare-products-table" class="products-table-container">
<?php	
		$table = new BE_Compare_Table_Products();
		$table->prepare_items();
		$table->display();
?>
	</div>
<?php
	}


	/**
	 * Generate compare product 'Edit' form
	 */
	public function edit_product_form() {
		$product_id = (int) $_POST[ 'product_id' ];

		if( $product_id ) :
			$product = get_product( $product_id );
			$product_title = $product->get_title();
			$product_compare_enabled = sanitize_title( get_post_meta( $product_id, 'enable_compare_product', true ) );
			$product_compare_category = sanitize_title( get_post_meta( $product_id, 'selcat_compare_product', true ) );
			$saved_data = (array) get_post_meta( $product_id, 'compare_product_data', true );

			// Setup category select options
			$catOps = "<option>Select a category to view more options</option>";
			$features = get_option( 'be_compare_categories' );
			if( $features ) {
				foreach( $features as $key => $val ){
					$catOps .= '<option value="' . esc_attr( $key ) . '"';
					if( $product_compare_category == $key ) $catOps .= ' selected="selected"';
					$catOps .= '>' . $val[ 'title' ] . '</option>';
				}
			}
?>
	<form method="post">
		<?php wp_nonce_field( 'be-compare-product-edit', 'be-nonce' ); ?>
		<input type="hidden" name="product_id" id="product_id" value="<?php echo (int) $product_id; ?>" />
		<p><label class="title"><?php echo $product_title; ?></label></p>
		<p><input type="checkbox" name="enable_compare" <?php checked( $product_compare_enabled, 'yes', true ); ?> id="comp_enabled" /><span><?php _e( 'Activate compare ability for this product', 'be-compare-products' ); ?></span></p>
		<div id="enabled_only"<?php if( $product_compare_enabled !== 'yes' ) echo ' style="display:none;"'; ?>>
	        <p><label><?php _e( 'Select a compare category', 'be-compare-products' ); ?></label></p>
			<p><select name="comp_category" id="comp_category"><?php echo $catOps; ?></select>
			<hr />
			<div class="labeled-form">
<?php
			if( $product_compare_category && !empty( $product_compare_category ) ) {
				$this->get_product_form_fields( $saved_data, $product_compare_category );
			}
?>
			</div>
		</div>
		<p><input type="submit" name="submit" value="<?php _e( 'Update', 'be-compare-products' ); ?>" class="form_submit" /></p>
		<p style="margin:0"><a href="#" class="cancel"><?php _e( 'Cancel', 'be-compare-products' ); ?></a></p>
		</form>
<?php	
		endif;

		die();
	}


	/**
	 * Generate the form fields for a given category
	 */
	function get_product_form_fields( $saved_data, $category = "" ) {
		// determine valid category ID
		if( !empty( $category ) )
			$cid = sanitize_title( $category );
		elseif( isset( $_POST[ 'category' ] ) )
			$cid = sanitize_title( $_POST[ 'category' ] );
		else return;

		// ensure category exists
		$existing_cats = get_option( 'be_compare_categories' );
		if( isset( $existing_cats[ $cid ] ) )
			$features = $existing_cats[ $cid ]['sub_cats'];
		else return;

		// setup form fields
		if( isset( $features ) && count( (array) $features ) ) {
			$existing_features = (array) get_option( 'be_compare_features' );

			// Sort features according to custom order
			uasort( $features, array( &$this, 'usort_reorder' ) );

			// setup subcategories
			foreach( $features as $sub_key => $sub ) {
				echo '<div class="section" subcat-id="' . $sub_key . '">';
				echo '<p class="subcategory_title">' . $sub[ 'title' ] . '</p>';

				// Sort features according to custom order
				uasort( $sub[ 'features' ], array( &$this, 'usort_reorder' ) );

				// Setup features for given subcategory
				foreach( $sub[ 'features' ] as $feat_key => $feat ) {

					if( isset( $existing_features[ $feat_key ] ) ) {

						$f = $existing_features[ $feat_key ];
						$selValue = ( isset( $saved_data[ $sub_key ][ $feat_key ] ) ) ? $saved_data[ $sub_key ][ $feat_key ] : '';
						echo '<p class="form-field"><label style="display:block;">' . $f[ 'title' ] . '</label>';
						$this->get_feature_form_field( $feat_key, $f[ 'type' ], $f[ 'options' ], $selValue, $sub_key );
						echo '</p>';
					}
				}
				echo '</div>';
			}
		}
	}

	/**
	 * Generate the form fields for a given feature
	 */
	function get_feature_form_field( $title, $type, $options, $value, $sub ) {
		$title = sanitize_title( $title );
		$id = sanitize_title( $title ) . '-' . $sub;

		switch ( $type ) {
			case 'multi-select':
				$sel_ops = explode( '||', $options );
				foreach( $sel_ops as $val ) {
					$id = sanitize_title( $val ) . '-' . $sub;
					$checked = ( in_array( sanitize_text_field( $val ), (array) $value ) ) ? 'checked="checked"' : '';
					echo '<input type="checkbox" name="' . $title . '" id="' . $id . '" value="' . sanitize_text_field( $val ) . '" ' . $checked . ' /><label for="' . $id . '">' . esc_attr( stripslashes( $val ) ) . '</label> &nbsp; ';
				}
				break;
			case 'single-select':
				echo '<select name="' . $title . '" id="' . $id . '">';
				$sel_ops = explode( '||', $options );
				foreach( $sel_ops as $val )
					echo '<option value="' . sanitize_text_field( $val ) . '" ' . selected( sanitize_text_field( $val ), $value, false) . '>' . esc_attr( stripslashes( $val ) ) . '</option>';
				echo '</select>';
				break;
			case 'bool':
				echo '<input type="radio" name="' . $title . '" value="yes" ' . checked( $value, 'yes', false ) . ' id="yes-' . $id . '" /> <label for="yes-' . $id . '">Yes</label> &nbsp; ';
				echo '<input type="radio" name="' . $title . '" value="no" ' . checked( $value, 'no', false ) . ' id="no-' . $id . '" /> <label for="no-' . $id . '">No</label>';
				break;
			case 'text-area':
				echo '<textarea name="' . $title . '" id="' . $id . '">' . esc_attr( stripslashes( $value ) ) . '</textarea>';
				break;
			case 'text-input':
			default:
				echo '<input type="text" name="' . $title . '" value="' . esc_attr( stripslashes( $value ) ) . '" id="' . $id . '" />';
				break;
		}
	}


	/**
	 * Generate compare product 'Edit' form
	 */
	public function update_product_form() {
		$product_id = (int) $_POST[ 'product_id' ];
		$category_id = sanitize_title( $_POST[ 'category' ] );

		$existing_cats = get_option( 'be_compare_categories' );
		if( !isset( $existing_cats[ $category_id ] ) ) die();
?>
		<div class="labeled-form">
			<?php $this->get_product_form_fields( $category_id ); ?>
		</div>
<?php	
		die();
	}


	/**
	 * Сохранание параметров продукта в модальном окне
	 */
	public function save_product_form() {
		// check security tag
		check_ajax_referer( 'be-compare-product-edit', 'security' );

		// Update enabled status
		$post_id = (int) $_POST[ 'product_id' ];
		$enable_compare_product = sanitize_title( $_POST[ 'enabled' ] );
		$selcat_compare_product = ( isset( $_POST[ 'categoryID' ] ) ) ? sanitize_title( $_POST[ 'categoryID' ] ) : false;

		update_post_meta( $post_id, 'enable_compare_product', ( isset( $enable_compare_product ) && $enable_compare_product == 'true' ) ? 'yes' : 'no' );
		if( $selcat_compare_product )  update_post_meta( $post_id, 'selcat_compare_product', $selcat_compare_product );

		if( sanitize_title( $_POST[ 'enabled' ] ) == 'true' ) :

			if( isset( $_POST[ 'post' ] ) && isset( $_POST[ 'product_id' ] ) ) :
				$fields = array();

				print_r($_POST[ 'post' ]);

				foreach( $_POST[ 'post' ] as $k1 => $v1 ) {
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

			endif;

		endif;

		echo "SUCCESS";

		die();
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

}

return new BE_Compare_Settings_Products();

endif;

?>