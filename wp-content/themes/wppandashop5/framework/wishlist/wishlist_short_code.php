<?php 

add_shortcode( 'pwlp_wishlist', 'pwlp_wishlist_shortcode' );

	function pwlp_wishlist_shortcode(){
		
		ob_start();
		
		session_start();
		
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
		
					
		?>
			
		<form class="woocommerce" method="post" action="" id="pwlp_form">
			<div class="">
				<h2 style="color:<?php echo (isset($title_wi_page_col)&& !empty($title_wi_page_col))?$title_wi_page_col:'#141412'?>;"><?php echo ($title_wl_page!='')? $title_wl_page:'My wishlist on '.get_bloginfo('name'); ?></h2>
			</div>
		
			<table  class="shop_table cart pwlp_table">
				<thead>
						<tr > 
							<th class="pwl_product-remove"></th>
							<th class="product-thumbnail"></th>
							<th class="product-name">
								<span class="nobr">Product Name</span>
							</th>
							<th class="product-price">
								<span class="nobr">Unit Price</span>
							</th>
							<th class="product-stock-stauts">
								<span class="nobr">Stock Status</span>
							</th>
							<th class="product-add-to-cart"></th>
						</tr>
				</thead>
				
				<tbody>
				<?php 
				
					if(isset($_SESSION['wishlist']) && !empty($_SESSION['wishlist'])){
						
						if(is_user_logged_in()){
								
							
							$pwllp_user_ID = get_current_user_id();
							
							$wishList_data=get_user_meta($pwllp_user_ID,'_pwlp_wishlist');
							
							$wishList_data=$wishList_data[0];
							
							
						} else{
							
							$wishList_data=$_SESSION['wishlist'];	
						
						} 
						/* echo "<pre>";
						echo "user login";
						print_r($_SESSION['wishlist']);
						echo "user_not_login";
						print_r($_SESSION['wishlist']);
						print_r($wishList_data);
						echo "</pre>"; */
						foreach($wishList_data as $pro_id => $wish_date){

							$_pwlp = new WC_Product_Factory();
							
							$pwlp_product=$_pwlp->get_product($pro_id);
							
							$pwlp_product->get_availability();
							
							$pur = $pwlp_product->is_purchasable() && $pwlp_product->is_in_stock() ? 'add_to_cart_button' : '';
						
						?>
					
								<tr id="pwlp_product_<?php echo $pro_id;?>" >
									<td class="product-remove">
										<a class="remove pwlp_remove_id" data-remove-id="<?php echo $pro_id; ?>" >×</a>
									</td>
									
									<td class="product-thumbnail">
										<?php
											$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $pwlp_product->get_image(), $cart_item, $cart_item_key );

											if ( ! $pwlp_product->is_visible() )
												echo $thumbnail;
											else
												printf( '<a href="%s">%s</a>', $pwlp_product->get_permalink( $cart_item ), $thumbnail );
										?>
									</td>

									<td class="product-name">
										<?php
											if ( ! $pwlp_product->is_visible() )
												echo apply_filters( 'woocommerce_cart_item_name', $pwlp_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
											else
												echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', $pwlp_product->get_permalink( $cart_item ), $pwlp_product->get_title() ), $cart_item, $cart_item_key );

											// Meta data
											echo WC()->cart->get_item_data( $cart_item );

											// Backorder notification
											if ( $pwlp_product->backorders_require_notification() && $pwlp_product->is_on_backorder( $cart_item['quantity'] ) )
												echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';
										?>
									</td>

									<td class="product-price">
										
										<span class="amount">
										<?php $pwlp_price= $pwlp_product->price; 
												if (!empty($pwlp_price)){
													echo get_woocommerce_currency_symbol(); 
													echo $pwlp_price;
												}?>
										</span>
									</td>
									
									<td class="product-stock-status">
										<span class="wishlist-in-stock"><?php echo $pwlp_stock=$pwlp_product->stock_status;?></span> 
									</td>
									
									<td class="product-add-to-cart">
									<?php if(isset($adding_date_wishlist)&& ($adding_date_wishlist==1)){ ?>
										<span>Add on :<?php echo $wish_date;?></span>
									<?php } ?>
										<a href="<?php if(isset($add_to_cart_red)){echo ($add_to_cart_red==1)? site_url()."/cart?add-to-cart=".$pro_id :$pwlp_product->add_to_cart_url();}else{ echo $pwlp_product->add_to_cart_url(); } ?>" data-product_id="<?php echo $pro_id; ?>"  class="pwlp_add_to_cart button <?php echo $pur.' product_type_'.$product_type; ?>"><?php echo $pwlp_product->add_to_cart_text(); ?></a>    
										
									</td>
								</tr>
						<?php  }
					}else{ ?>
					<tr>
						<td colspan="6" class="wishlist-empty" style="text-align:center;">
							No products were added to the wishlist
						</td>
					</tr>
					<?php } ?>
				</tbody>
		
				<tfoot>
						<tr>
							<td colspan="6">
								<?php require_once('pwlp_share.php'); ?>
							</td>
						</tr>
				</tfoot>
			</table>

		</form>
			
<?php }

?>
