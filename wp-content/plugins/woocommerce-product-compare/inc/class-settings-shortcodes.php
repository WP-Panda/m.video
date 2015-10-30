<?php
/**
 * Bolder Compare Products Settings Class.
 *
 * @author 		Bolder Elements
 * @category 	Inc
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'BE_Compare_Settings_Shortcodes' ) ) :

/**
 * BE_Compare_Settings
 */
class BE_Compare_Settings_Shortcodes extends WC_Settings_Page {

	/**
	 * Constructor.
	 */
	public function __construct() {

		$this->id    = 'shortcodes';
		$this->label = __( 'Shortcodes', 'be-compare-products' );

		add_filter( 'be_compare_settings_tabs_array', array( $this, 'add_settings_page' ), 40 );
		add_action( 'be_compare_settings_' . $this->id, array( $this, 'output' ) );
		add_action( 'be_compare_settings_save_' . $this->id, array( $this, 'save' ) );
		add_action( 'be_compare_settings_tabs_shortcodes', array( &$this, 'output' ) );

		if ( ( $styles = WC_Frontend_Scripts::get_styles() ) && array_key_exists( 'woocommerce-general', $styles ) )
			add_action( 'woocommerce_admin_field_frontend_styles', array( $this, 'frontend_styles_setting' ) );
	}


	/**
	 * Display Tab output
	 */
	function output() {

		$GLOBALS['hide_save_button'] = true;
?>
	<div class="be_compare_admin">
		<blockquote class="be_compare_quote">
			Introduced in WordPress 2.5 is the Shortcode API, a simple set of functions for creating macro codes for use in post content. It enables plugin developers to create special kinds of content that users can attach to certain pages by adding the corresponding shortcode into the page text.
			<p>- WordPress.org</p>
		</blockquote>

		<p>In other words, the following bits of code will allow you to place compare tables in more locations than those directly specified by the plugin.</p>

		<h3>Session Table</h3>
		<p>This plugin requires you to select an existing page whose content will be overwritten to display the comparison table for products that the user has selected. If you wish to display this table in a second location, the following shortcode will supply the table.</p>
		<p><pre>[compare_table]</pre></p>

		<h3>Table for Specific Products</h3>
		<p>Tables can also be displayed for specific products that you can choose. The shortcode accepts one attribute: products. This attribute will accept the ID number for a single product.</p>
		<p><strong>Single Product</strong><pre>[compare_table products="42"]</pre></p>
		<p>This shortcode attribute can also accept multiple product ID numbers but separating each ID with a comma</p>
		<p><strong>Multiple Products</strong><pre>[compare_table products="42,73,86"]</pre></p>
		
		<h3>From My Theme</h3>
		<p>If you need to place a comparison table somewhere in your website via a template file, WordPress has a handy function that will allow you to execute a shortcode from a PHP file.</p>
		<p><pre>&lt;?php echo do_shortcode( '[compare_table products="42,73,86"]' ); ?&gt;</pre></p>

		<h3>&nbsp;</h3>
		<p><em>NOTE: Product ID numbers can be found editing the product whose ID you need. Similar to the URL shown below, the ID can be seen as the 'post' attribute of your page address.</em></p>
		<p><pre><em>http://yourwebsite.com/wp-admin/post.php?<span style="color:red;">post=79</span>&action=edit</em></pre></p>
	</div>
<?php
	}


	/**
	 * Save settings
	 */
	public function save() { return; }

}

return new BE_Compare_Settings_Shortcodes();

endif;

?>