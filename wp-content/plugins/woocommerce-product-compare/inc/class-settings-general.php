<?php
/**
 * Bolder Compare Products Settings Class.
 *
 * @author 		Bolder Elements
 * @category 	Inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'BE_Compare_Settings_General' ) ) :

/**
 * BE_Compare_Settings
 */
class BE_Compare_Settings_General extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id    = 'settings';
		$this->label = __( 'Settings', 'be-compare-products' );

		add_filter( 'be_compare_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
		add_action( 'be_compare_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'be_compare_settings_save_' . $this->id, array( $this, 'save' ) );

	}

	/**
	 * Get settings array
	 *
	 * @return array
	 */
	public function get_settings() {

		return apply_filters( 'be_compare_settings', array(

			array( 'title' => __( 'General Options', 'be-compare-products' ), 'type' => 'title', 'desc' => '', 'id' => 'general_options' ),

			array(
				'title' 	=> __( 'Enable Product Comparison', 'be-compare-products' ),
				'desc' 		=> __( 'Allow users to select similar products for comparison.', 'be-compare-products' ),
				'id' 		=> 'be_compare_enabled',
				'default'	=> 'no',
				'type' 		=> 'checkbox',
			),

			array(
				'title'		=> __( 'Comparison Page', 'be-compare-products' ),
				'desc'		=> __( 'This is the page that will display the comparison table when a user clicks the Compare button', 'be-compare-products' ),
				'id'		=> 'be_compare_page',
				'type'		=> 'single_select_page',
				'class'		=> 'chosen_select',
				'css' 		=> 'min-width: 350px;',
				'desc_tip'	=>  true,
			),

			array(
				'title' 	=> __( 'Compare Button Location', 'be-compare-products' ),
				'desc' 		=> __( 'Choose where the button appears on the single product page', 'be-compare-products' ),
				'id' 		=> 'be_compare_button_location',
				'default'	=> 'after-price',
				'type' 		=> 'select',
				'class'		=> 'chosen_select',
				'css' 		=> 'min-width: 350px;',
				'options' 	=> array(
					'after-title' 		=> __( 'Below Product Title', 'be-compare-products'),
					'after-price' 		=> __( 'Below Product Price', 'be-compare-products' ),
					'after-summary' 	=> __( 'Below Short Summary','be-compare-products' ),
					'after-categories' 	=> __( 'Below Categories', 'be-compare-products' ),
				),
				'desc_tip'	=>  true,
			),

			array(
				'title' 	=> __( 'Compare Button Visibility', 'be-compare-products' ),
				'desc' 		=> __( 'Choose where the button can appear in shop', 'be-compare-products' ),
				'id' 		=> 'be_compare_button_visibility',
				'default'	=> 'all',
				'type' 		=> 'select',
				'class'		=> 'chosen_select',
				'css' 		=> 'min-width: 350px;',
				'options' 	=> array(
					'all' 			=> __( 'All Locations', 'be-compare-products'),
					'only-shop' 	=> __( 'Shop Listing / Archive Only', 'be-compare-products' ),
					'only-single'	=> __( 'Single Product Pages Only','be-compare-products' ),
				),
				'desc_tip'	=>  true,
			),

			array(
				'title' 	=> __( 'Compare Preview Location', 'be-compare-products' ),
				'desc' 		=> __( 'Display a box of product icons the user has selected to compare', 'be-compare-products' ),
				'id' 		=> 'be_compare_preview_location',
				'default'	=> 'page-top',
				'type' 		=> 'select',
				'class'		=> 'chosen_select',
				'css' 		=> 'min-width: 350px;',
				'options' 	=> array(
					'page-top' 		=> __( 'Top of Page', 'be-compare-products'),
					'page-bottom' 	=> __( 'End of Page', 'be-compare-products' ),
					'no-show' 		=> __( 'Do not show this preview','be-compare-products' ),
				),
				'desc_tip'	=>  true,
			),

			array(
				'title' 	=> __( 'Compare Limit', 'be-compare-products' ),
				'desc' 		=> __( 'The maximum number of items a user can compare', 'be-compare-products' ),
				'default'	=> __( '4', 'be-compare-products' ),
				'id' 		=> 'be_compare_compare_limit',
				'type' 		=> 'number',
			),

			array(
				'title'		=> __( 'Hide Compare on Mobile/Tablet Devices', 'be-compare-products' ),
				'desc' 		=> __( 'Removes the compare buttons, preview table, and compare table', 'be-compare-products' ),
				'id' 		=> 'be_compare_hide_mobile',
				'default'	=> 'no',
				'type' 		=> 'checkbox',
			),

			array( 'type' => 'sectionend', 'id' => 'general_options'),

			array(	'title' => __( 'Features Tab', 'be-compare-products' ), 'type' => 'title', 'id' => 'features_box' ),

			array(
				'title' 	=> __( 'Enable Features Tab', 'be-compare-products' ),
				'desc' 		=> __( 'Allow users to view a complete list of features on the single product page.', 'be-compare-products' ),
				'id' 		=> 'be_compare_features_enabled',
				'default'	=> 'yes',
				'type' 		=> 'checkbox',
			),

			array(
				'title' 	=> __( 'Title', 'be-compare-products' ),
				'desc' 		=> __( 'Allow users to view a complete list of features on the single product page.', 'be-compare-products' ),
				'default'	=> __( 'Features', 'be-compare-products' ),
				'id' 		=> 'be_compare_features_title',
				'type' 		=> 'text',
				'css' 		=> 'min-width: 350px;',
			),

			array(
				'title' => __( 'Tab Location', 'be-compare-products' ),
				'desc' 		=> __( 'Choose which position the tab appears', 'be-compare-products' ),
				'id' 		=> 'be_compare_features_location',
				'default'	=> 'after-reviews',
				'type' 		=> 'select',
				'class'		=> 'chosen_select',
				'css' 		=> 'min-width: 350px;',
				'options' => array(
					'before-desc' 		=> __( 'Before Description Tab', 'be-compare-products'),
					'before-additional'	=> __( 'Before Additional Tab', 'be-compare-products' ),
					'before-reviews' 	=> __( 'Before Reviews Tab','be-compare-products' ),
					'after-reviews' 	=> __( 'After Reviews Tab', 'be-compare-products' ),
				)
			),

			array( 'type' => 'sectionend', 'id' => 'features_box' ),

		) ); // End general settings
	}


	/**
	 * Save settings
	 */
	public function save() {
		$settings = $this->get_settings();

		WC_Admin_Settings::save_fields( $settings );

	}

}

return new BE_Compare_Settings_General();

endif;

?>