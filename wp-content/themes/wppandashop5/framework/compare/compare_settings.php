<?php 

	function compare_settings(){
	wp_enqueue_script('wp-color-picker'); 
	wp_enqueue_style('wp-color-picker');		
	wp_enqueue_script("pcp-color_picker-js", plugin_dir_url( __FILE__ )."js/pcp_color_picker.js",array('jquery'),'',true);
	wp_enqueue_style( 'style_custom_request', plugin_dir_url( __FILE__ ).'css/custom_css.css' );
	
		if($_POST['pcp_save_all']){
			
			$is_enable= sanitize_text_field( $_POST['pcp_enable_product_page'] );
			$is_button= sanitize_text_field( $_POST['pcp_is_button'] );
			$bt_lk_text= sanitize_text_field( $_POST['pcp_button_text'] );
			$bt_product_page= sanitize_text_field( $_POST['pcp_button_in_product_page'] );
			$bt_product_list= sanitize_text_field( $_POST['pcp_button_in_products_list'] );
			$auto_open= sanitize_text_field( $_POST['pcp_auto_open'] );
			$table_text= sanitize_text_field( $_POST['pcp_table_text'] );
			$fields_attr= $_POST['pcp_woocompare_fields_attrs'] ;
			$pcp_image_width= sanitize_text_field( $_POST['pcp_image_width'] );
			$pcp_image_height= sanitize_text_field( $_POST['pcp_image_height'] );
			$cmp_txt_clr= sanitize_text_field( $_POST['cmp_txt_color'] );
			$cmp_bt_clr= sanitize_text_field( $_POST['cmp_bt_color'] );
			$pcp_data=array('is_enable'=>$is_enable,'is_button'=>$is_button,'bt_lk_text'=>$bt_lk_text,
					'bt_product_page'=>$bt_product_page,'bt_product_list'=>$bt_product_list,
					'auto_open'=>$auto_open,'table_text'=>$table_text,
					'fields_attr'=>serialize($fields_attr),'pcp_image_width'=>$pcp_image_width,
					'pcp_image_height'=>$pcp_image_height,
					'cmp_txt_clr'=>$cmp_txt_clr,'cmp_bt_clr'=>$cmp_bt_clr,
					);
			
				
		update_option('data_compare_product',$pcp_data);
		
		}
		
		$pcp_dataa=get_option('data_compare_product');
		if(!empty($pcp_dataa)){
			extract($pcp_dataa);
			$fields_attr=unserialize($fields_attr);
		}
		
			
	?>
	
	<form method="post" id="pcp_form">
        <h3>General Settings</h3>
		<table class="form-table">
			<tbody>
				<tr valign="top" class="">
					<th class="titledesc" scope="row">Enable Plugin</th>
					<td class="forminp forminp-checkbox">
						<fieldset>
							<legend class="screen-reader-text"></legend>
							<label for="pcp_button_in_product_page">
								<input type="checkbox"  value="1" <?php echo ($is_enable==1)?'checked':'' ;?> id="pcp_enable_product_page" name="pcp_enable_product_page"> 
							</label> 
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="row">
						<label for="pcp_woocompare_is_button">Button Or Link</label>
					</th>
					<td class="forminp forminp-select">
						<select class="" id="pcp_is_button" name="pcp_is_button">
							<option <?php echo ($is_button=='Button')? 'selected' : '' ;?> value="Button">Button</option>
							<option <?php echo ($is_button=='link')? 'selected' : '' ;?> value="link">Link</option>
					   </select> <span class="description">Choose if you want to use a button or a link for action.</span>						
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="row">
						<label for="pcp_button_text">Button/Link text</label>
					</th>
					<td class="forminp forminp-text">
						<input type="text" value="<?php echo ($bt_lk_text!='')?$bt_lk_text:'compare'; ?>" style="" id="pcp_button_text" name="pcp_button_text"> <span class="description">Type the text to use for the Link or Button.</span>						
					</td>
				</tr>
				<tr valign="top" class="">
					<th class="titledesc" scope="row">Show Compare on Product Page</th>
					<td class="forminp forminp-checkbox">
						<fieldset>
							<legend class="screen-reader-text"><span>Show button in single product page</span></legend>
							<label for="pcp_button_in_product_page">
								<input type="checkbox"  value="1" <?php echo ($bt_product_page==1)?'checked':'' ;?> id="pcp_button_in_product_page" name="pcp_button_in_product_page"> Say if you want to show the button on the single product page.
							</label> 
						</fieldset>
					</td>
				</tr>
				<tr valign="top" class="">
					<th class="titledesc" scope="row">Show Compare on Product List</th>
					<td class="forminp forminp-checkbox">
						<fieldset>
							<legend class="screen-reader-text"><span>Show button in products list</span></legend>
							<label for="pcp_button_in_products_list">
								<input type="checkbox"  value="1" <?php echo ($bt_product_list==1)?'checked':'' ;?> id="pcp_button_in_products_list" name="pcp_button_in_products_list"> Say if you want to show the button in the products list.
							</label>
						</fieldset>
					</td>
				</tr>
				<tr valign="top" class="">
					<th class="titledesc" scope="row">Immediately open Compare Popup</th>
					<td class="forminp forminp-checkbox">
						<fieldset>
							<legend class="screen-reader-text"><span>Open automatically lightbox</span></legend>
							<label for="pcp_woocompare_auto_open">
								<input type="checkbox"  value="1" <?php echo ($auto_open==1)?'checked':'' ;?> class="" id="pcp_auto_open" name="pcp_auto_open"> Open link after click on "Compare" button".
							</label> 
						</fieldset>
					</td>
				</tr>
			</tbody>
		</table>
		
		<h3>Compare Table Settings</h3>
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th class="titledesc" scope="row">
						<label for="pcp_woocompare_table_text">Table title</label>
					</th>
					<td class="forminp forminp-text">
						<input type="text"  value="<?php echo ($table_text!='')? $table_text: "Compare Table" ;?>" style="" id="pcp_woocompare_table_text" name="pcp_table_text"> <span class="description">Type the text to use for table title.</span>
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="row">
						<label for="pcp_woocompare_fields_attrs">Fields to show</label>
					</th>

					<td class="forminp attributes">
						<p class="description">Select the fields to show in comparison table </p>
						<ul class="fields ui-sortable">
							<li class="ui-sortable-handle">
								<label>
									<input type="checkbox" <?php if(isset($fields_attr)){ if(in_array('image',$fields_attr)){echo "checked";}}?> value="image" id="pcp_woocompare_fields_attrs_image" name="pcp_woocompare_fields_attrs[]"> Image
								</label>
							</li>
							<li class="ui-sortable-handle">
								<label>
									<input type="checkbox" <?php if(isset($fields_attr)){ if(in_array('title',$fields_attr)){echo "checked";} }?>  value="title" id="pcp_woocompare_fields_attrs_title" name="pcp_woocompare_fields_attrs[]"> Title								
								</label>
							</li>
							<li class="ui-sortable-handle">
								<label>
									<input type="checkbox" <?php if(isset($fields_attr)){ if(in_array('price',$fields_attr)){echo "checked";} }?>  value="price" id="pcp_woocompare_fields_attrs_price" name="pcp_woocompare_fields_attrs[]"> Price								
								</label>
							</li>
							<li class="ui-sortable-handle">
								<label>
									<input type="checkbox" <?php if(isset($fields_attr)){ if(in_array('add-to-cart',$fields_attr)){echo "checked";}} ?>  value="add-to-cart" id="pcp_woocompare_fields_attrs_add-to-cart" name="pcp_woocompare_fields_attrs[]"> Add to cart
								</label>
							</li>
							<li class="ui-sortable-handle">
								<label>
									<input type="checkbox" <?php if(isset($fields_attr)){ if(in_array('description',$fields_attr)){echo "checked";} }?>  value="description" id="pcp_woocompare_fields_attrs_description" name="pcp_woocompare_fields_attrs[]"> Description
								</label>
							</li>
							<li class="ui-sortable-handle">
								<label>
									<input type="checkbox" <?php if(isset($fields_attr)){ if(in_array('stock',$fields_attr)){ echo "checked";} }?> value="stock" id="pcp_woocompare_fields_attrs_stock" name="pcp_woocompare_fields_attrs[]"> Availability
								</label>
							</li>
						</ul>
						
					</td>
				</tr>
				<tr valign="top">
					<th class="titledesc" scope="row">Image size</th>
					<td class="forminp image_width_settings">
						<input type="number" min="0" size="4" value="<?php echo ($pcp_image_width!='' && $pcp_image_width>0)?$pcp_image_width:220?>" id="pcp_image_width" name="pcp_image_width"> X
						<input type="number" min="0" size="4" value="<?php echo ($pcp_image_height!='' && $pcp_image_height>0)?$pcp_image_height:154?>" id="pcp_image_height" name="pcp_image_height">px
	
						<p class="description">Set the size for the images</p>

					</td>
				</tr>
			</tbody>
		</table> 
		<h3>Style Table Settings</h3>
		<table class="form-table">
			<tbody>
				<tr class="user-user-login-wrap">
					<th><label for="cmp_txt_color">Compare Text Color:</label></th>
					<td><input type="text" class="popup_bg_color" value="<?php echo ($cmp_txt_clr!='')?$cmp_txt_clr:'' ;?>" id="cmp_txt_color" name="cmp_txt_color"></td>
				</tr>
				<tr class="user-user-login-wrap">
					<th><label for="cmp_bt_color">Compare Button Color:</label></th>
					<td><input type="text" class="popup_bg_color" value="<?php echo ($cmp_bt_clr!='')?$cmp_bt_clr:''; ?>" id="cmp_bt_color" name="cmp_bt_color"></td>
				</tr>
			</tbody>
		</table>		
		<input type="submit" value="Save Changes" class="button-primary" name="pcp_save_all"  style="float: left; margin-right: 10px;">
		
    </form>
		
	
	<?php 
	}
	
?>