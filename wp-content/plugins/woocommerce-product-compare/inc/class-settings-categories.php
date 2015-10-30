<?php
/**
 * Bolder Compare Products Categories Settings Class.
 *
 * @author 		Bolder Elements
 * @category 	Inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'BE_Compare_Settings_Categories' ) ) :

/**
 * BE_Compare_Settings
 */
class BE_Compare_Settings_Categories extends WC_Settings_Page {

	public $categories_save;
	public $features_save;

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id    = 'cats';
		$this->label = __( 'Categories', 'be-compare-products' );
		$this->categories_save = "be_compare_categories";
		$this->features_save = "be_compare_features";

		require_once( 'class-table-categories.php' );
		require_once( 'class-table-features.php' );

		add_filter( 'be_compare_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'be_compare_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'be_compare_settings_save_' . $this->id, array( $this, 'save' ) );
		add_action( 'be_compare_settings_tabs_categories', array( &$this, 'output' ) );
		add_action( 'be_compare_sections_' . $this->id, array( $this, 'output_sections' ) );
		add_action( 'admin_footer', array( $this, 'add_script_admin' ) );

		// AJAX functions
		/**
		 * Создание новой категории продуктов
		 */
		add_action( 'wp_ajax_be_compare_add_category', array( &$this, 'add_compare_category' ) );
		add_action( 'wp_ajax_be_compare_delete_category', array( &$this, 'delete_compare_category' ) );
		add_action( 'wp_ajax_be_compare_add_subcategory', array( &$this, 'add_compare_subcategory' ) );
		add_action( 'wp_ajax_be_compare_delete_subcategory', array( &$this, 'delete_compare_subcategory' ) );
		add_action( 'wp_ajax_be_compare_add_existing_feature', array( &$this, 'add_existing_feature' ) );
		add_action( 'wp_ajax_be_compare_add_existing_attribute', array( &$this, 'add_existing_attribute' ) );
		add_action( 'wp_ajax_be_compare_create_feature', array( &$this, 'create_compare_feature' ) );
		add_action( 'wp_ajax_be_compare_remove_feature', array( &$this, 'remove_compare_feature' ) );
		add_action( 'wp_ajax_be_compare_delete_feature', array( &$this, 'delete_compare_feature' ) );
		add_action( 'wp_ajax_be_compare_delete_features', array( &$this, 'delete_compare_features' ) );
		add_action( 'wp_ajax_be_compare_edit_feature_form', array( &$this, 'return_feature_settings' ) );
		add_action( 'wp_ajax_be_compare_edit_feature', array( &$this, 'update_feature_settings' ) );
		add_action( 'wp_ajax_be_compare_update_order_cat', array( &$this, 'update_compare_order_cat' ) );
		add_action( 'wp_ajax_be_compare_update_order_feat', array( &$this, 'update_compare_order_feat' ) );
		add_action( 'wp_ajax_be_compare_update_table_feat', array( &$this, 'update_table_features' ) );
		add_action( 'wp_ajax_be_compare_update_list_features', array( &$this, 'add_script_admin' ) );
	}


	/**
	 * Divide this tab into sections
	 */
	public function get_sections() {
		$sections = array(
			''          			=> __( 'Categories & Features', 'be-compare-products' ),
			'manage-features'		=> __( 'Manage Features', 'be-compare-products' ),
		);

		return $sections;
	}


	/**
	 * Output the settings
	 */
	public function output() {
		global $current_section;
		$GLOBALS['hide_save_button'] = true;

		$settings = $this->get_settings( $current_section );
		BE_Compare_Settings::output_fields( $settings );

		if( $current_section == '' ) 
			$this->show_table_categories();
		elseif( $current_section == 'manage-features' )
			$this->show_table_features();
	}

	/**
	 * Output sections
	 */
	public function output_sections() {
		global $current_section;

		$sections = $this->get_sections();

		if ( empty( $sections ) )
			return;

		echo '<ul class="subsubsub">';

		$array_keys = array_keys( $sections );

		foreach ( $sections as $id => $label )
			echo '<li><a href="' . admin_url( 'admin.php?page=be-compare-products&tab=' . $this->id . '&section=' . sanitize_title( $id ) ) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . $label . '</a> ' . ( end( $array_keys ) == $id ? '' : '|' ) . ' </li>';

		echo '</ul><br class="clear" />';
	}


	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings( $current_section = '' ) {

		if ( $current_section == 'manage-features' ) {
			return apply_filters( 'be_compare_settings_features', array(

			array( 
				'title' => __( 'Compare Features', 'be-compare-products' ), 
				'type' => 'title', 
				'desc' => __( 'Below is a list of currently available features for product comparison. From here you may edit and delete the existing features, but new ones must be added when setting up your categories.', 'be-compare-products' ), 
				'id' => 'features_options'
			),

			array( 'type' => 'sectionend', 'id' => 'features_options'),

			) );
		} else {
			return apply_filters( 'be_compare_settings_categories', array(

				array( 
					'title' => __( 'Product Categories', 'be-compare-products' ), 
					'type' => 'title', 
					'desc' => __( 'Create the categories that comparable products will be assigned to. This will also manage the sub-categories and various features within each.', 'be-compare-products' ), 
					'id' => 'general_options'
				),

				array( 'type' => 'sectionend', 'id' => 'general_options'),

			) );
		}
	}


	/**
	 * No settings to save
	 */
	public function save() { }


	/**
	 * Сохранение новой категории характеристик
	 */
	public function save_new_category( $title ) {

		$existing_cats = $this->get_categories();
		$title = sanitize_text_field( $title );
		$key = sanitize_title( 'cr_par_cat_' .  hash( 'crc32b', $title ) );

		if( empty( $key ) ) return;

		if( !$existing_cats ) $existing_cats = array();

		if( !array_key_exists( $key, $existing_cats ) ) {
			$existing_cats[ $key ] = array( 'title' => $title, 'status' => 1, 'sub_cats' => array() );
			update_option( $this->categories_save, (array) $existing_cats );
		}
	}


	/**
	 * Save settings
	 */
	public function remove_category( $cid ) {
		
		$existing_cats = $this->get_categories();
		$key = sanitize_title( $cid );

		if( !$existing_cats ) $existing_cats = array();

		if( array_key_exists( $key, $existing_cats ) ) {
			unset( $existing_cats[ $key ] );
			update_option( $this->categories_save, (array) $existing_cats );
		}
	}


	/**
	 * Сохранение новой подкатегории
	 */
	public function save_new_subcategory( $title, $cat_id ) {
		
		$existing_cats = $this->get_categories();
		$title = sanitize_text_field( $title );
		$key = sanitize_title( hash( 'crc32b', $title ) );
		$cat_id = sanitize_title( $cat_id );

		if( !$existing_cats || !$existing_cats[ $cat_id ] ) return;

		if( !array_key_exists( $key, $existing_cats[ $cat_id ]['sub_cats'] ) ) {
			$existing_cats[ $cat_id ][ 'sub_cats' ][ 'cr_compare_'  . $key ] = array( 'title' => $title, 'status' => 1, 'features' => array() );
			update_option( $this->categories_save, (array) $existing_cats );
		}
	}


	/**
	 * Save settings
	 */
	public function remove_subcategory( $sub_id, $cat_id ) {
		
		$existing_cats = $this->get_categories();
		$cat_id = sanitize_title( $cat_id );
		$sub_id = sanitize_title( $sub_id );

		if( !$existing_cats || !$existing_cats[ $cat_id ] ) return;

		if( array_key_exists( $sub_id, $existing_cats[ $cat_id ][ 'sub_cats' ] ) ) {
			unset( $existing_cats[ $cat_id ][ 'sub_cats' ][ $sub_id ] );
			update_option( $this->categories_save, (array) $existing_cats );
		}
	}


	/**
	 * Save settings
	 */
	public function delete_feature( $fid ) {
		
		$existing_cats = $this->get_categories();
		$existing_feats = $this->get_features();
		$key = sanitize_title( $fid );

		if( !$existing_feats ) $existing_feats = array();

		if( array_key_exists( $key, $existing_feats ) ) {
			// Remove from subcategories
			foreach( $existing_cats as $k1 => $v1 ) {
				foreach( $v1[ 'sub_cats' ] as $k2 => $v2 ) {
					if( isset( $existing_cats[ $k1 ][ 'sub_cats' ][ $k2 ][ 'features' ][ $key ] ) )
						unset( $existing_cats[ $k1 ][ 'sub_cats' ][ $k2 ][ 'features' ][ $key ] );
				}
			}

			// Remove from list of existing features
			unset( $existing_feats[ $key ] );
			update_option( $this->features_save, (array) $existing_feats );
			update_option( $this->categories_save, (array) $existing_cats );
		}
	}

	/**
	 * Get saved categories
	 *
	 * @return array
	 */
	public function get_categories() {

		return get_option( $this->categories_save );
	}

	/**
	 * Get saved features
	 *
	 * @return array
	 */
	public function get_features() {

		return get_option( $this->features_save );
	}


	/**
	 * Сохранение новой категории продуктов
	 *
	 * @return array
	 */
	public function add_compare_category() {

		// Sanitize input fields
		$title = sanitize_text_field( $_POST['title'] );

		// Save new category
		$this->save_new_category( $title );

		// Display newly updated category list
		$this->show_table_categories();

		die();
	}


	/**
	 * Save new categories
	 *
	 * @return array
	 */
	public function delete_compare_category() {

		// Sanitize input fields
		$cid = sanitize_title( $_POST['cid'] );

		// Save new category
		$this->remove_category( $cid );

		// Display newly updated category list
		$this->show_table_categories();

		die();
	}


	/**
	 * Добавление новой субкатегории
	 *
	 * @return array
	 */
	public function add_compare_subcategory() {

		// Sanitize input fields
		$cat_id = sanitize_title( $_POST['cat_id'] );
		$title = sanitize_text_field( $_POST['title'] );

		// Save new category
		$this->save_new_subcategory( $title, $cat_id );

		// Display newly updated category list
		$this->update_subcategory_table( $cat_id );

		die();
	}


	/**
	 * Save new categories
	 *
	 * @return array
	 */
	public function delete_compare_subcategory() {

		// Sanitize input fields
		$cat_id = sanitize_title( $_POST['cat_id'] );
		$sub_id = sanitize_title( $_POST['sub_id'] );

		// Save new category
		$this->remove_subcategory( $sub_id, $cat_id );

		// Display newly updated category list
		$this->update_subcategory_table( $cat_id );

		die();
	}


	/**
	 * Add existing feature to subcategory
	 *
	 * @return array
	 */
	public function add_existing_feature() {

		// Sanitize input fields
		$cat_id = sanitize_title( $_POST['cat_id'] );
		$sub_id = sanitize_title( $_POST['sub_id'] );
		$feat_id = sanitize_title( $_POST['feat_id'] );

		// Save new feature to subcategory
		$this->add_feature( $feat_id, $sub_id, $cat_id );

		// Display newly updated category list
		$this->update_subcategory_table( $cat_id );

		die();
	}


	/**
	 * Add existing attribute to subcategory
	 *
	 * @return array
	 */
	public function add_existing_attribute() {

		// Sanitize input fields
		$cat_id = sanitize_title( $_POST['cat_id'] );
		$sub_id = sanitize_title( $_POST['sub_id'] );
		$attr_id = 'attr_' . sanitize_title( $_POST['attr_id'] );

		// Save new feature to subcategory
		$this->add_feature( $attr_id, $sub_id, $cat_id );

		// Display newly updated category list
		$this->update_subcategory_table( $cat_id );

		die();
	}


	/**
	 * Save new categories
	 *
	 * @return array
	 */
	public function create_compare_feature() {

		// Sanitize input fields
		$cat_id = sanitize_title( $_POST['cat_id'] );
		$sub_id = sanitize_title( $_POST['sub_id'] );
		$feat_title = sanitize_text_field( $_POST['feat_title'] );
		$feat_type = sanitize_text_field( $_POST['feat_type'] );
		$feat_ops = sanitize_text_field( str_replace( "\n", "||", $_POST['feat_ops'] ) );

		// create new feature
		$feat_id = $this->create_new_feature( $feat_title, $feat_type, $feat_ops );

		// Save new feature to subcategory
		$this->add_feature( $feat_id, $sub_id, $cat_id );

		// Display newly updated category list
		$this->update_subcategory_table( $cat_id );

		die();
	}


	/**
	 * Созданрие нового поля
	 */

	public function create_new_feature( $title, $type, $options, $fid = null ) {
		
		$existing_feats = $this->get_features();
		$title = sanitize_text_field( $title );
		$key = ( empty( $fid ) ) ? 'cr_param_' . sanitize_title( hash( 'crc32b', $title ) ) : $fid;
		$type = sanitize_title( $type );
		$options = sanitize_text_field( $options );

		if( !$existing_feats ) $existing_feats = array();

		if( !empty( $fid ) || !array_key_exists( $key, $existing_feats ) ) {
			$existing_feats[ $key ] = array( 'title' => $title, 'status' => 1, 'type' => $type, 'options' => $options );
			update_option( $this->features_save, (array) $existing_feats );
		}

		return $key;
	}


	/**
	 * Save settings
	 */
	public function add_feature( $feat_id, $sub_id, $cat_id ) {
		
		$existing_cats = $this->get_categories();
		$cat_id = sanitize_title( $cat_id );
		$sub_id = sanitize_title( $sub_id );
		$feat_id = sanitize_title( $feat_id );

		if( !$existing_cats || !$existing_cats[ $cat_id ]['sub_cats'][ $sub_id ] ) return;

		if( !in_array( $feat_id, $existing_cats[ $cat_id ]['sub_cats'][ $sub_id ][ 'features' ] ) ) {
			$existing_cats[ $cat_id ][ 'sub_cats' ][ $sub_id ][ 'features' ][ $feat_id ] = array( 'status' => 1 );
			update_option( $this->categories_save, (array) $existing_cats );
		}

	}


	/**
	 * Save new categories
	 *
	 * @return array
	 */
	public function remove_compare_feature() {

		// Sanitize input fields
		$cat_id = sanitize_title( $_POST['cat_id'] );
		$sub_id = sanitize_title( $_POST['sub_id'] );
		$feat_id = sanitize_title( $_POST['feat_id'] );

		// Delete feature from subcategory
		$this->remove_feature( $feat_id, $sub_id, $cat_id );

		// Display newly updated category list
		$this->update_subcategory_table( $cat_id );

		die();
	}


	/**
	 * Remove feature from category and save settings
	 */
	public function remove_feature( $feat_id, $sub_id, $cat_id ) {
		
		$existing_cats = $this->get_categories();
		$cat_id = sanitize_title( $cat_id );
		$sub_id = sanitize_title( $sub_id );
		$feat_id = sanitize_title( $feat_id );

		if( !$existing_cats || !$existing_cats[ $cat_id ]['sub_cats'][ $sub_id ] ) return;

		if( array_key_exists( $feat_id, $existing_cats[ $cat_id ]['sub_cats'][ $sub_id ][ 'features' ] ) ) {
			unset( $existing_cats[ $cat_id ][ 'sub_cats' ][ $sub_id ][ 'features' ][ $feat_id ] );
			update_option( $this->categories_save, (array) $existing_cats );
		}

	}


	/**
	 * Delete selected feature from list
	 *
	 * @return array
	 */
	public function delete_compare_feature() {

		// Sanitize input fields
		$fid = sanitize_title( $_POST['feat_id'] );

		// Remove feature from list
		$this->delete_feature( $fid );

		die();
	}


	/**
	 * Delete selected features from list
	 *
	 * @return array
	 */
	public function delete_compare_features() {

		// Sanitize input fields
		$fids = sanitize_text_field( $_POST['feat_ids'] );
		$feats = explode( ',', $fids );

		if( count( $feats ) )
			foreach( $feats as $fid ) {
				// Remove feature from list
				$this->delete_feature( $fid );
			}

		die();
	}


	/**
	 * Return settings needed for future form
	 *
	 * @return array
	 */
	public function return_feature_settings() {

		// Sanitize input fields
		$fid = sanitize_title( $_POST['feat_id'] );

		$existing_feats = $this->get_features();

		if( !$existing_feats ) $existing_feats = array();

		if( array_key_exists( $fid, $existing_feats ) ) {
			// Return settings values
			echo $existing_feats[ $fid ][ 'title' ] . '&|&';
			echo $existing_feats[ $fid ][ 'type' ] . '&|&';
			echo str_replace( '||', "\n", $existing_feats[ $fid ][ 'options' ] );
		}

		die();
	}


	/**
	 * Process Update Feature form
	 *
	 * @return array
	 */
	public function update_feature_settings() {

		// Sanitize input fields
		$fid = sanitize_title( $_POST[ 'feat_id' ] );
		$title = sanitize_text_field( $_POST[ 'feat_title' ] );
		$type = sanitize_title( $_POST[ 'feat_type' ] );
		$ops = sanitize_text_field( str_replace( "\n", "||", $_POST['feat_ops'] ) );

		// Update feature settings
		$this->create_new_feature( $title, $type, $ops, $fid );

		die();
	}


	/**
	 * Update table after delete
	 *
	 * @return array
	 */
	public function update_table_features() {

		// Display newly updated category list
		$this->show_table_features();

		die();
	}


	/**
	 * Create and display WP list class for categories
	 */
	public function show_table_categories() {
?>
    <div id="be-compare-cat-tables">
<?php
		$categories = $this->get_categories();

		if( $categories ) :
			foreach ($categories as $key => $value) {
				$table = new BE_Compare_Table_Categories( array( 'cat' => $value, 'key' => $key ) );
				$table->display();
			}
		endif;

?>
		<a href="#" class="add button category" class="alignleft"><?php _e( 'Add Category', 'be-compare-products' ); ?></a>
    </div>
<?php
	}


	/**
	 * Update subcategory listing after changes are made
	 */
	public function update_subcategory_table( $cat_id ) {
		$categories = $this->get_categories();
		$table = new BE_Compare_Table_Categories();

		if( isset( $categories[ $cat_id ] ) ) {
			$table->display_category_info( $categories[ $cat_id ], $cat_id );
		}
	}


	/**
	 * Update order of subcategories after dragging
	 */
	public function update_compare_order_cat() {
		$cat_id = sanitize_title( $_POST['cat_id'] );
		$existing_cats = $this->get_categories();

		foreach( $_POST[ 'items' ] as $key => $value ) {
			if( isset( $existing_cats[ $cat_id ][ 'sub_cats' ][ $value ] ) )
				$existing_cats[ $cat_id ][ 'sub_cats' ][ $value ][ 'order' ] = $key;
		}
		echo "SUCCESS";
		update_option( $this->categories_save, (array) $existing_cats );

		die();
	}


	/**
	 * Update order of subcategories after dragging
	 */
	public function update_compare_order_feat() {
		$cat_id = sanitize_title( $_POST['cat_id'] );
		$sub_id = sanitize_title( $_POST['sub_id'] );
		$existing_cats = $this->get_categories();

		foreach( $_POST[ 'items' ] as $key => $value ) {
			if( isset( $existing_cats[ $cat_id ][ 'sub_cats' ][ $sub_id ][ 'features' ][ $value ] ) )
				$existing_cats[ $cat_id ][ 'sub_cats' ][ $sub_id ][ 'features' ][ $value ][ 'order' ] = $key;
		}
		echo "SUCCESS";
		update_option( $this->categories_save, (array) $existing_cats );

		die();
	}


	/**
	 * Create and display WP list class for features
	 */
	public function show_table_features() {
?>
    <div id="be-compare-feat-table">
<?php
		$features = $this->get_features();

		$table = new BE_Compare_Table_Features( array( 'features' => $features ) );
		$table->prepare_items();
		$table->display();

?>
    </div>
<?php
	}


	/**
	 * Add Script Directly to Dashboard Foot
	 */
	public function add_script_admin() {

		// Setup existing features list
		$features = $this->get_features();
		$attributes = wc_get_attribute_taxonomies();
		$js_string = $js_string_attr = "";
		$comma = 0;

		if( $features )
			foreach( $features as $key => $value ) {
				if( $comma > 0 ) $js_string .= ',';
				$js_string .= '"' . $key . '":"' . $value[ 'title' ] . '"';
				$comma++;
			}

		$comma = 0;
		if( $attributes )
			foreach( $attributes as $value ) {
				if( $comma > 0 ) $js_string_attr .= ',';
				$js_string_attr .= '"' . $value->attribute_id . '":"' . $value->attribute_label . '"';
				$comma++;
			}
?>
<script type="text/javascript" id="be_compare_features_list">
/* <![CDATA[ */
var be_compare_feature_types = {<?php echo $js_string; ?>}
var be_compare_attribute_types = {<?php echo $js_string_attr; ?>}
/* ]]> */
</script>
<?php
		if( is_ajax() ) die();
	}

}

return new BE_Compare_Settings_Categories();

endif;

?>