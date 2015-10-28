<?php
/**
 * Plugin Name: WishList For WooCommerce

 * Plugin URI: http://www.phoeniixx.com/

 * Description: By adding Wishlist feature to your ecommerce site, you could let your customers save the items that they would like to purchase, but in future. This helps them in keeping track of items they desire to buy. The Wishlist Plugin also lets your customers share their Wishlist with friends through various social media platforms (Facebook, Pinterest, Google+ and/or Twitter).

 * Version: 1.0

 * Text Domain: pwlp

 * Domain Path: /i18n/languages/

 * Author: phoeniixx

 * Author URI: http://www.phoeniixx.com/

 * License: GPL2
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	// Put your plugin code here
	require_once(ABSPATH . 'wp-settings.php');

	error_reporting(0);

	ob_start();

	session_start();

	require_once('wishlist_settings.php');

	require_once('wishlist_short_code.php');

	function pwlp_add_to_cart_after() {

		$pwlp_genral_dataa=get_option('data_wishlist_genral');

		$pwlp_share_dataa=get_option('data_share_wishlist');

		$pwlp_style_dataa=get_option('data_style_wishlist');

		if(isset($pwlp_genral_dataa)&& !empty($pwlp_genral_dataa)|| isset($pwlp_share_dataa)&& !empty($pwlp_share_dataa)||isset($pwlp_style_dataa)&& !empty($pwlp_style_dataa)){

			extract($pwlp_genral_dataa);

			extract($pwlp_share_dataa);

			extract($pwlp_style_dataa);
		}

		if(isset($_GET['add-to-cart'])){
			if($rem_wl==1){

				$prod_id=$_GET['add-to-cart'];

				$wishlist_data=$_SESSION['wishlist'];

				foreach ($wishlist_data as $key => $value){
					if ($key == $prod_id) {
						unset($wishlist_data[$key]);
						$_SESSION['wishlist'] = $wishlist_data;

						if(is_user_logged_in()){

							$pwlp_user_ID = get_current_user_id();

							update_user_meta($pwlp_user_ID, '_pwlp_wishlist', $wishlist_data);
						}
					}
				}
			}
		}
	}

	add_action('woocommerce_after_cart_table', 'pwlp_add_to_cart_after');

	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	$pwlp_genral_dataa=get_option('data_wishlist_genral');

	$pwlp_share_dataa=get_option('data_share_wishlist');

	$pwlp_style_dataa=get_option('data_style_wishlist');

	if(isset($pwlp_genral_dataa)&& !empty($pwlp_genral_dataa)|| isset($pwlp_share_dataa)&& !empty($pwlp_share_dataa)||isset($pwlp_style_dataa)&& !empty($pwlp_style_dataa)){

		extract($pwlp_genral_dataa);

		extract($pwlp_share_dataa);

		extract($pwlp_style_dataa);
	}

	add_action('admin_menu', 'pwlp_wishlist_tab');

	function pwlp_wishlist_tab(){

		$page_title="WishList";

		$menu_title="WishList";

		$capability="manage_options";

		$menu_slug="pwlp-wishlist-manager";

		$plugin_dir_url =  plugin_dir_url( __FILE__ );

		add_menu_page( 'phoeniixx', __( 'Phoeniixx', 'phe' ), 'nosuchcapability', 'phoeniixx', NULL, $plugin_dir_url.'/images/logo-wp.png', 57 );

		add_submenu_page( 'phoeniixx', $page_title, $menu_title, $capability, $menu_slug ,'wishlist_settings');

	}

	add_action('wp_head', 'pwlp_assets_file');

	function pwlp_assets_file() {


		wp_enqueue_script("pwlp-share-js", WPS5_BASE_DIR .'framework/wishlist/js/pwlp_jqSocialSharer.min.js',array('jquery'),'',true);

		wp_enqueue_script( 'wishlist-ajax-request', WPS5_BASE_DIR .'framework/wishlist/js/pwlp_front_end_custom.js', array( 'jquery' ) );

		wp_localize_script( 'wishlist-ajax-request', 'WishListAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

		wp_enqueue_style( 'pwlp-custom-css', WPS5_BASE_DIR .'framework/wishlist/css/pwlp_custom_css.css' );

		$pwlp_genral_dataaa=get_option('data_wishlist_genral');

		$pwlp_share_dataaa=get_option('data_share_wishlist');

		$pwlp_style_dataaa=get_option('data_style_wishlist');

		if(isset($pwlp_genral_dataaa)&& !empty($pwlp_genral_dataaa)|| isset($pwlp_share_dataaa)&& !empty($pwlp_share_dataaa)||isset($pwlp_style_dataaa)&& !empty($pwlp_style_dataaa)){

			extract($pwlp_genral_dataaa);

			extract($pwlp_share_dataaa);

			extract($pwlp_style_dataaa);
		}
		?>
		<style>
			.pwlp_product {
				color:<?php echo (isset($add_wl_txt_clr)&& !empty($add_wl_txt_clr))?$add_wl_txt_clr:'#F3C589'  ?>!important;
			}
			.see_wish{
				color:<?php echo (isset($see_wl_txt_clr)&& !empty($see_wl_txt_clr))?$see_wl_txt_clr:'#F3C589' ?>!important;
			}
			.already_meg{
				color:<?php echo (isset($msg_color)&& !empty($msg_color))?$msg_color:'#141412' ?>!important;
			}
			.pr_added{
				color:<?php echo (isset($pr_add_txtcolor)&& !empty($pr_add_txtcolor))?$pr_add_txtcolor:'#141412' ?>!important;
			}
		</style>
		<script>
			var text_btn="<?php echo (isset($added_text)&&($added_text!=''))?$added_text:'Added'; ?>";
			var see_btn="<?php echo (isset($wl_see_text)&&($wl_see_text!=''))?$wl_see_text:'See WishList'; ?>";
			var whislist_page_name = "<?php echo $ptitle = get_the_title($wishlist_page);?>";

		</script>

		<?php
		if(is_user_logged_in()){


			$pwllp_user_ID = get_current_user_id();

			if(isset($_SESSION['wishlist'])){
				$wishList_data=$_SESSION['wishlist'];
				update_user_meta($pwllp_user_ID,'_pwlp_wishlist',$wishList_data);
			}

			$wishList_data=get_user_meta($pwllp_user_ID,'_pwlp_wishlist');

			if(!empty($wishList_data)){

				$_SESSION['wishlist']=$wishList_data[0];

			}else{

				$wishList_data=$_SESSION['wishlist'][0];
				update_user_meta($pwllp_user_ID,'_pwlp_wishlist',$wishList_data);
			}

		}
	}


	add_action('admin_head','pwlp_add_admin_assests');

	function pwlp_add_admin_assests(){

		wp_enqueue_script('wp-color-picker');

		wp_enqueue_style('wp-color-picker');

		wp_enqueue_style( 'pwlp-custom-css',  WPS5_BASE_DIR .'framework/wishlist/css/pwlp_custom_css.css' );

		wp_enqueue_script("pwlp-custom-js",  WPS5_BASE_DIR .'framework/wishlist/js/pwlp_custom.js',array('jquery'),'',true);

		wp_enqueue_script("pwlp-selct-js","http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js" ,array('jquery'),'',true);

		wp_enqueue_style( 'pwlp-select-css', 'http://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css' );

		?>
		<script>
			var whislist_title="<?php echo 'My wishlist on '.get_bloginfo('name');?>";
		</script>
		<?php
	}

	add_action( 'wp_ajax_pwlp_data_retrive', 'pwlp_data_retrive' );

	add_action( 'wp_ajax_nopriv_pwlp_data_retrive', 'pwlp_data_retrive' );

	function pwlp_data_retrive(){

		if(isset($_POST['pwlprod_id'])){

			if(isset($_SESSION['wishlist'])){

				$wishlist_data=$_SESSION['wishlist'];
				//echo "session";
				//print_r($wishlist_data);
				$wl_product_id=$_POST['pwlprod_id'];

				if(!array_key_exists($wl_product_id,$wishlist_data)){

					$wishlist_item_time = date_i18n('j F Y', time());

					$wishlist_data[$wl_product_id]=$wishlist_item_time;

					$_SESSION['wishlist'] = $wishlist_data;
					//print_r($wishlist_data);
					if(is_user_logged_in()){

						$pwlp_user_ID = get_current_user_id();

						update_user_meta($pwlp_user_ID, '_pwlp_wishlist', $wishlist_data);
					}
				}
			}else{

				$_SESSION['wishlist']=array();
				if(isset($_SESSION['wishlist'])){
					$wishlist_data=$_SESSION['wishlist'];
					//print_r($wishlist_data);
					$wl_product_id=$_POST['pwlprod_id'];

					if(!array_key_exists($wl_product_id,$wishlist_data)){

						$wishlist_item_time = date_i18n('j F Y', time());

						$wishlist_data[$wl_product_id]=$wishlist_item_time;

						$_SESSION['wishlist'] = $wishlist_data;

						if(is_user_logged_in()){

							$pwlp_user_ID = get_current_user_id();

							update_user_meta($pwlp_user_ID, '_pwlp_wishlist', $wishlist_data);
						}

					}
				}
			}

		}
		//print_r($_SESSION['wishlist']);
		die();
	}
	add_action( 'wp_ajax_pwlp_data_remove', 'pwlp_data_remove' );

	add_action( 'wp_ajax_nopriv_pwlp_data_remove', 'pwlp_data_remove' );

	function pwlp_data_remove(){

		if(isset($_POST['pwlpremove_id'])){

			if(isset($_SESSION['wishlist'])){
				$wishlist_data=$_SESSION['wishlist'];
				//print_r($wishlist_data);
				$wl_remove_id=$_POST['pwlpremove_id'];

				foreach ($wishlist_data as $key => $value){

					if ($key == $wl_remove_id) {
						unset($wishlist_data[$key]);
						$_SESSION['wishlist'] = $wishlist_data;

						if(is_user_logged_in()){

							$pwlp_user_ID = get_current_user_id();

							update_user_meta($pwlp_user_ID, '_pwlp_wishlist', $wishlist_data);
						}
					}
				}
				echo $wl_remove_id;
			}
		}

		die();
	}


	register_activation_hook( __FILE__, 'pwlp_plugin_activate' );
	function pwlp_plugin_activate(){

		$pwlp_gena_data=get_option('data_wishlist_genral');
		if(empty($pwlp_gena_data)){
			$pwlp_genral_data=array('is_enable'=>1);
			update_option('data_wishlist_genral',$pwlp_genral_data);
		}
		$pwlp_shr_data=get_option('data_share_wishlist');
		if(empty($pwlp_shr_data)){

			$pwlp_shr_data=array('share_fb'=>1,'share_gp'=>1,
				'share_pin'=>1,'share_twt'=>1,'tit_social_net'=>'Share On:',
				'pwlp_msg_text'=>'',
			);
			update_option('data_share_wishlist',$pwlp_shr_data);
		}

	}


	function clear_wishlist_session() {
		session_unset();
	}
	add_action('wp_logout', 'clear_wishlist_session');


	//add_action('woocommerce_single_product_summary','pwlp_product_display',35);

	/**
	 * Êíîïêà Wishlist
	 */
	function pwlp_product_display(){
		$pwlp_genral_dataaa=get_option('data_wishlist_genral');
		$pwlp_share_dataaa=get_option('data_share_wishlist');
		$pwlp_style_dataaa=get_option('data_style_wishlist');

		if(isset($pwlp_genral_dataaa)&& !empty($pwlp_genral_dataaa)|| isset($pwlp_share_dataaa)&& !empty($pwlp_share_dataaa)||isset($pwlp_style_dataaa)&& !empty($pwlp_style_dataaa)){
			extract($pwlp_genral_dataaa);
			extract($pwlp_share_dataaa);
			extract($pwlp_style_dataaa);
		}

		$pwlp_change=$_SESSION['wishlist'];
		global $product ;
		$pro_id= $product->id;
		if($is_enable==1){
			$ptitle = get_the_title($wishlist_page);
			if(array_key_exists($pro_id,$pwlp_change)){
				echo "<a href='".site_url()."/".$ptitle."/' target='_blank' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='" . __('See Wishlist','wppandashop5') . "'></li>";
				//echo "<a href='".site_url()."/".$ptitle."/' target='_blank' class='see_wish'>".$wl_see_text."</a>";
			}else{
				?>
				<li>
					<a class="pwlp_product btn btn-primary whislist"  id="pwlp_<?php echo $product->id ;?>" data-product-id="<?php echo $product->id ;?>" href="javascript:void(0)" data-toggle='tooltip' data-placement='top' title="<?php _e('Add to Wishlist','wppandashop5'); ?>">
						<i class="icon fa fa-heart"></i>
					</a>
				</li>
			<?php }
		}
	}

	/**
	 * Êíîïêà Wishlist 2
	 */
	function cr_product_display($text){
		$pwlp_genral_dataaa=get_option('data_wishlist_genral');
		$pwlp_share_dataaa=get_option('data_share_wishlist');
		$pwlp_style_dataaa=get_option('data_style_wishlist');

		if(isset($pwlp_genral_dataaa)&& !empty($pwlp_genral_dataaa)|| isset($pwlp_share_dataaa)&& !empty($pwlp_share_dataaa)||isset($pwlp_style_dataaa)&& !empty($pwlp_style_dataaa)){
			extract($pwlp_genral_dataaa);
			extract($pwlp_share_dataaa);
			extract($pwlp_style_dataaa);
		}

		$pwlp_change=$_SESSION['wishlist'];
		global $product ;
		$pro_id= $product->id;
		if($is_enable==1){
			$ptitle = get_the_title($wishlist_page);
			if(array_key_exists($pro_id,$pwlp_change)){
				echo "<a href='".site_url()."/".$ptitle."/' target='_blank' class='btn btn-primary see_wish alt' data-toggle='tooltip' data-placement='top' title='" . __('See Wishlist','wppandashop5') . "'>" . esc_html($text) . "</a>";
			}else{
				?>
					<a class="pwlp_product btn btn-primary whislistt"  id="pwlp_<?php echo $product->id ;?>" data-product-id="<?php echo $product->id ;?>" href="javascript:void(0)" data-toggle='tooltip' data-placement='top' title="<?php _e('Add to Wishlist','wppandashop5'); ?>">
						<?php echo  esc_html($text) ?>
					</a>
			<?php }
		}
	}


}
else
{
	?>
	<div class="error notice is-dismissible " id="message"><p>Please <strong>Activate</strong> WooCommerce Plugin First, to use Infinite Scrolling - Woocommerce Plugin.</p><button class="notice-dismiss" type="button"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
	<?php
}
?>