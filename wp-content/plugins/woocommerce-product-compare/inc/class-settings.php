<?php
/**
 * Bolder Compare Products Settings Class.
 *
 * @author 		Bolder Elements
 * @category 	Inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'BE_Compare_Settings' ) ) :

class BE_Compare_Settings extends WC_Admin_Settings {

	private static $settings = array();
	private static $errors   = array();
	private static $messages = array();

	/**
	 * Include the settings page classes
	 */
	public static function get_settings_pages() {
		if ( empty( self::$settings ) ) {
			$settings = array();

			include_once( WC()->plugin_path() . '/includes/admin/settings/class-wc-settings-page.php' );

			$settings[] = include( 'class-settings-general.php' );
			$settings[] = include( 'class-settings-categories.php' );
			$settings[] = include( 'class-settings-products.php' );
			$settings[] = include( 'class-settings-shortcodes.php' );

			self::$settings = apply_filters( 'be_compare_settings_pages', $settings );
		}
		return self::$settings;
	}

	/**
	 * Save the settings
	 */
	public static function save() {
		global $current_section, $current_tab;

		if ( empty( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'be-compare-settings' ) )
	    		die( __( 'Action failed. Please refresh the page and retry.', 'be-compare-products' ) );

	    // Trigger actions
	   	do_action( 'be_compare_settings_save_' . $current_tab );
	    do_action( 'be_compare_update_options_' . $current_tab );
	    do_action( 'be_compare_update_options' );

    	// Clear any unwanted data
		wc_delete_product_transients();
		delete_transient( 'woocommerce_cache_excluded_uris' );

		self::add_message( __( 'Your settings have been saved.', 'be-compare-products' ) );
		self::check_download_folder_protection();

		// Re-add endpoints and flush rules
		WC()->query->init_query_vars();
		WC()->query->add_endpoints();
		flush_rewrite_rules();

		do_action( 'be_compare_settings_saved' );
	}

	/**
	 * Settings page.
	 *
	 * Handles the display of the main woocommerce settings page in admin.
	 *
	 * @access public
	 * @return void
	 */
	public static function output() {
	    global $current_section, $current_tab;

	    do_action( 'be_compare_settings_start' );

	    wp_enqueue_script( 'woocommerce_settings', WC()->plugin_url() . '/assets/js/admin/settings.min.js', array( 'jquery', 'jquery-ui-datepicker', 'jquery-ui-sortable', 'iris', 'chosen' ), WC()->version, true );

		wp_localize_script( 'woocommerce_settings', 'woocommerce_settings_params', array(
			'i18n_nav_warning' => __( 'The changes you made will be lost if you navigate away from this page.', 'be-compare-products' )
		) );

		// Include settings pages
		self::get_settings_pages();

		// Get current tab/section
		$current_tab     = empty( $_GET['tab'] ) ? 'settings' : sanitize_title( $_GET['tab'] );
		$current_section = empty( $_REQUEST['section'] ) ? '' : sanitize_title( $_REQUEST['section'] );

	    // Save settings if data has been posted
	    if ( ! empty( $_POST ) )
	    	self::save();

	    // Add any posted messages
	    if ( ! empty( $_GET['wc_error'] ) )
	    	self::add_error( stripslashes( $_GET['wc_error'] ) );

	     if ( ! empty( $_GET['wc_message'] ) )
	    	self::add_message( stripslashes( $_GET['wc_message'] ) );

	    self::show_messages();

	    // Get tabs for the settings page
	    $tabs = apply_filters( 'be_compare_settings_tabs_array', array() );

	    include 'html-settings.php';
	}

}
endif;
?>