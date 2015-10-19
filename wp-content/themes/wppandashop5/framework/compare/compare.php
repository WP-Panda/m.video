<?php
/**
 * Plugin Name: Compare Products Lite for WooCommerce
 * Plugin URI: http://www.phoeniixx.com/
 * Description: Compare Product lite for Woo Commerce Plugin gives your customers, an option to side-by-side compare, multiple choices of a product, on a common popup window. The customers could do this side-by-side comparison, on the basis of multiple features like Price, Availability, Colors, Size etc., thus getting assistance in choosing the most suitable option.
 * Version: 1.2
 * Text Domain: pcp
 * Domain Path: /i18n/languages/
 * Author: Phoeniixx
 * Author URI: http://www.phoeniixx.com/
 * License: GPL2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	// Put your plugin code here
	ob_start();
	session_start();
	require_once(ABSPATH . 'wp-settings.php');
	error_reporting(0);

	require_once('compare_settings.php');
	$pcp_compare_data=get_option('data_compare_product');
	if(!empty($pcp_compare_data)){
		extract($pcp_compare_data);
		if(isset($fields_attr)){
			$fields_attr=unserialize($fields_attr);
		}
	}

	add_action('wp_head', 'add_assets_file');

	function add_assets_file(){
		wp_enqueue_script('wp-color-picker');

		wp_enqueue_style('wp-color-picker');

		wp_enqueue_style( 'style_colorbox_request', WPS5_BASE_DIR . 'framework/compare/css/pcp_colorbox.css' );

		wp_enqueue_style( 'style_custom_request',  WPS5_BASE_DIR . 'framework/compare/css/custom_css.css' );

		wp_enqueue_script("pcp-colorbox-min-js",  WPS5_BASE_DIR . 'framework/compare/js/pcp_colorbox-min.js',array('jquery'),'',true);

		wp_enqueue_script( 'compare-ajax-request',  WPS5_BASE_DIR . 'framework/compare/js/pcp_custom.js', array( 'jquery' ) );

		wp_localize_script( 'compare-ajax-request', 'CompareAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

		$pcp_compare_data=get_option('data_compare_product');
		if(!empty($pcp_compare_data)){
			extract($pcp_compare_data);
			if(isset($fields_attr) || $fields_attr!=''){
				$fields_attr=unserialize($fields_attr);
			}
		}
		?>
		<div style='display:none'>
			<div id='pcpinline_content' style='padding:10px; background:#fff;'>
				<h2 class="plugin_heading"><?php echo ($table_text!='')?$table_text:'Compare Table'; ?></h2>
				<table class="compare_heading">
					<tr><td> &nbsp; </td></tr>
					<?php if(in_array('title',$fields_attr)){?><tr><td class="compare_text_tit">Title </td></tr><?php } ?>
					<?php if(in_array('description',$fields_attr)){?><tr><td class="compare_text_desc">Description </td></tr><?php } ?>
					<?php if(in_array('image',$fields_attr)){?><tr><td class="compare_text_image"> Image </td></tr><?php } ?>
					<?php if(in_array('price',$fields_attr)){?><tr><td class="compare_text_prc"> Price </td></tr><?php } ?>
					<?php if(in_array('stock',$fields_attr)){?><tr><td class="compare_text_avl">Availability </td></tr><?php } ?>
					<?php if(in_array('add-to-cart',$fields_attr)){?><tr><td>Add to cart </td></tr><?php } ?>
				</table>
				<div class="table_class">
					<div class="tabel_data">
					</div>
				</div>
			</div>
		</div>
		<style>
			.compare_prod_image img{
				width:<?php echo ($pcp_image_width!='' && $pcp_image_width>0)?$pcp_image_width:220 ?>px!important;
				height:<?php echo ($pcp_image_height!='' && $pcp_image_height>0)?$pcp_image_height:154 ?>px!important;
			}
		</style>
		<?php
	}


	add_action('admin_menu', 'pcp_comapre_tab');

	function pcp_comapre_tab(){

		$page_title="Compare Product";
		$menu_title="Compare";
		$capability="manage_options";
		$menu_slug="pcp-compare-manager";
		$plugin_dir_url =  plugin_dir_url( __FILE__ );
		add_menu_page( 'phoeniixx', __( 'Phoeniixx', 'phe' ), 'nosuchcapability', 'phoeniixx', NULL, $plugin_dir_url.'/images/logo-wp.png', 57 );
		add_submenu_page( 'phoeniixx', $page_title, $menu_title, $capability, $menu_slug ,'compare_settings');

	}


	function pcp_shop_display_compare() {
		$pcp_compare_data=get_option('data_compare_product');
		//print_r($pcp_compare_data);
		if(!empty($pcp_compare_data)){
			extract($pcp_compare_data);
			if(isset($fields_attr) || $fields_attr!=''){
				$fields_attr=unserialize($fields_attr);
			}
		}
		if(isset($bt_product_page)&& ($bt_product_page==1)){
			if(isset($fields_attr ) || $fields_attr!=''){
				$fields_attr=unserialize($fields_attr);
			}
		}
		if(isset($auto_open)&& ($auto_open==1)){
			wp_enqueue_script("pcp-quick-js", plugin_dir_url( __FILE__ )."js/quick_display.js",array('jquery'),'',true);
		}
		if(!isset($_SESSION['compare_data'])){
			$compare_data=array();
			$_SESSION['compare_data']=$compare_data;
		}
		$compare_product=$_SESSION['compare_data'];
		//print_r($compare_product);

		wp_enqueue_style( 'style_custom_request', plugin_dir_url( __FILE__ ).'css/custom_css.css' );
		global $product;
		if($is_enable==1){
			if (!empty($product)) { ?>
				<li>
					<a class="pcpcompare compare_product_popup btn btn-primary compare"  data-value="<?php echo $product->id ;?>" href="javascript:void(0)">
						<i class="fa fa-exchange"></i>
					</a>
				</li>
				<?php
			}
		}
	}



	add_action( 'wp_ajax_pcp_data_retrive', 'pcp_data_retrive' );

	add_action( 'wp_ajax_nopriv_pcp_data_retrive', 'pcp_data_retrive' );

	function pcp_data_retrive(){
		global $product;
		$pcp_compare_data=get_option('data_compare_product');
		if(!empty($pcp_compare_data)){
			extract($pcp_compare_data);
			if(isset($fields_attr) || $fields_attr!=''){
				$fields_attr=unserialize($fields_attr);
			}
		}

		/* print_r($fields_attr); */
		if(!empty($_SESSION)){

			$compare_data=$_SESSION['compare_data'];

			if(isset($_POST['prod_id'])){

				$product_id=$_POST['prod_id'];
				if(!in_array($product_id,$compare_data)){
					$compare_data[]=$product_id;
					$_SESSION['compare_data'] = $compare_data;
				}

				//print_r($_SESSION['compare_data']);
				?>


				<?php
				foreach($compare_data as $com_pro_id){

					$_pf = new WC_Product_Factory();

					$all_product=$_pf->get_product($com_pro_id);

					$all_product->get_availability();

					$pr_type = $all_product->product_type;

					$pur = $all_product->is_purchasable() && $all_product->is_in_stock() ? 'add_to_cart_button' : '';

					$src = wp_get_attachment_image_src( get_post_thumbnail_id($com_pro_id),'full');

					$product_image=$src[0];

					$product_type = esc_attr( $all_product->product_type );

					?>
					<table class="compare_item">

						<tr><td><a class="button remove_product_id" data-value="<?php echo $com_pro_id; ?>" >Remove</a></td></tr>
						<?php if(in_array('title',$fields_attr)){?><tr><td class="compare_prod_tit"><?php $pr_title= get_the_title($com_pro_id) ;if(strlen($pr_title)>20){ echo  $pr_title = substr($pr_title, 0, 20)."...";}else{echo $pr_title;}?></td></tr><?php } ?>
						<?php if(in_array('description',$fields_attr)){?><tr><td class="compare_prod_desc"><?php $pr_desc= $all_product->post->post_content; if(strlen($pr_desc)>20){ echo $pr_desc = substr($pr_desc, 0, 20)."...";}else{ echo $pr_desc;}?><td></tr><?php } ?>
						<?php if(in_array('image',$fields_attr)){?><tr><td class="compare_prod_image"><img class="woocommerce-placeholder" src="<?php if($product_image!=''){ echo $product_image;}else{ echo site_url()."/wp-content/plugins/woocommerce/assets/images/placeholder.png";}//$all_product->get_image();?>" alt="Placeholder"></td></tr><?php } ?>
						<?php if(in_array('price',$fields_attr)){?><tr><td class="compare_prod_prc"><?php echo get_woocommerce_currency_symbol(); $pr_price= $all_product->price; if(strlen($pr_price)>20){ echo $pr_price = substr($pr_price, 0, 20)."...";}else{echo $pr_price;} ?> </td></tr><?php } ?>
						<?php if(in_array('stock',$fields_attr)){?><tr><td class="compare_prod_avl"><?php $pr_stock=$all_product->stock_status;  if(strlen($pr_stock)>20){ echo $pr_stock = substr($pr_stock, 0, 20)."...";}else{ echo $pr_stock;} ?> </td></tr><?php } ?>
						<?php if(in_array('add-to-cart',$fields_attr)){?><tr><td><a href="<?php echo $all_product->add_to_cart_url(); ?>" data-product_id="<?php echo $com_pro_id; ?>"  class="button <?php echo $pur.' product_type_'.$product_type; ?>"><?php echo $all_product->add_to_cart_text(); ?></a></td></tr><?php } ?>
					</table>

				<?php }
			}

		}


		die();
	}

	add_action( 'wp_ajax_pcp_product_id_remove', 'pcp_product_id_remove' );

	add_action( 'wp_ajax_nopriv_pcp_product_id_remove', 'pcp_product_id_remove' );

	function pcp_product_id_remove(){

		$pcp_compare_data=get_option('data_compare_product');
		if(!empty($pcp_compare_data)){
			extract($pcp_compare_data);
			if(isset($fields_attr) || $fields_attr!=''){
				$fields_attr=unserialize($fields_attr);
			}
		}
		$remove_pro_id=$_POST['remove_prod_id'];

		if(!empty($remove_pro_id)){
			$compare_product_data = $_SESSION['compare_data'];
			foreach ($compare_product_data as $key => $value){
				if ($value == $remove_pro_id) {
					unset($compare_product_data[$key]);
					$_SESSION['compare_data'] = $compare_product_data;
				}
			}
			//print_r($_SESSION['compare_data']);
			?>

			<?php
			foreach($_SESSION['compare_data'] as $com_pro_id){

				$_pf = new WC_Product_Factory();

				$all_product=$_pf->get_product($com_pro_id);

				$pr_type = $all_product->product_type;

				$pur = $all_product->is_purchasable() && $all_product->is_in_stock() ? 'add_to_cart_button' : '';

				$src = wp_get_attachment_image_src( get_post_thumbnail_id($com_pro_id),'full');

				$product_image=$src[0];

				$product_type = esc_attr( $all_product->product_type );
				?>
				<table class="compare_item">
					<tr><td><a class="button remove_product_id" data-value="<?php echo $com_pro_id; ?>" >Remove</a></td></tr>
					<?php if(in_array('title',$fields_attr)){?><tr><td class="compare_prod_tit"><?php $pr_title= get_the_title($com_pro_id) ;if(strlen($pr_title)>30){ echo  $pr_title = substr($pr_title, 0, 30)."...";}else{echo $pr_title;}?></td></tr><?php } ?>
					<?php if(in_array('description',$fields_attr)){?><tr><td class="compare_prod_desc"><?php $pr_desc= $all_product->post->post_content; if(strlen($pr_desc)>30){ echo $pr_desc = substr($pr_desc, 0, 30)."...";}else{ echo $pr_desc;}?><td></tr><?php } ?>
					<?php if(in_array('image',$fields_attr)){?><tr><td class="compare_prod_image"><img class="woocommerce-placeholder" src="<?php if($product_image!=''){ echo $product_image;}else{ echo site_url()."/wp-content/plugins/woocommerce/assets/images/placeholder.png";}//$all_product->get_image();?>" alt="Placeholder"></td></tr><?php } ?>
					<?php if(in_array('price',$fields_attr)){?><tr><td class="compare_prod_prc"><?php echo get_woocommerce_currency_symbol(); $pr_price= $all_product->price; if(strlen($pr_price)>30){ echo $pr_price = substr($pr_price, 0, 30)."...";}else{echo $pr_price;} ?> </td></tr><?php } ?>
					<?php if(in_array('stock',$fields_attr)){?><tr><td class="compare_prod_avl"><?php $pr_stock=$all_product->stock_status;  if(strlen($pr_stock)>30){ echo $pr_stock = substr($pr_stock, 0, 30)."...";}else{ echo $pr_stock;} ?> </td></tr><?php } ?>
					<?php if(in_array('add-to-cart',$fields_attr)){?><tr><td><a href="<?php echo $all_product->add_to_cart_url(); ?>" data-product_id="<?php echo $com_pro_id; ?>"  class="button <?php echo $pur.' product_type_'.$product_type; ?>"><?php echo $all_product->add_to_cart_text(); ?></a></td></tr><?php } ?>
				</table>


			<?php }

		}
		die();
	}


	add_action('woocommerce_single_product_summary','pcp_product_display_compare',30);

	function pcp_product_display_compare() {
		$pcp_compare_data=get_option('data_compare_product');
		if(!empty($pcp_compare_data)){
			extract($pcp_compare_data);
			if(isset($fields_attr) || $fields_attr!=''){
				$fields_attr=unserialize($fields_attr);
			}
		}
		if(isset($bt_product_list)&& ($bt_product_list==1)){
			global $product;

			if(isset($fields_attr) || $fields_attr!=''){
				$fields_attr=unserialize($fields_attr);
			}
			if(isset($auto_open)&& ($auto_open==1)){
				wp_enqueue_script("pcp-quick-js", plugin_dir_url( __FILE__ )."js/quick_display.js",array('jquery'),'',true);
			}

			if(!isset($_SESSION['compare_data'])){
				$compare_data=array();
				$_SESSION['compare_data']=$compare_data;
			}

			$compare_product=$_SESSION['compare_data'];

			wp_enqueue_style( 'style_custom_request', plugin_dir_url( __FILE__ ).'css/custom_css.css' );
			if($is_enable==1){
				?>
				<li>
					<a class="pcpcompare compare_product_popup btn btn-primary compare"  data-value="<?php echo $product->id ;?>" href="javascript:void(0)">
						<i class="fa fa-exchange"></i>
					</a>
				</li>
				<?php
			}
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