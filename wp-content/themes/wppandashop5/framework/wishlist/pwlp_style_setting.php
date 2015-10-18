<form method="post" class="pwlp_style">
<?php 
if($_POST['pwlp_style_setting']){
			
		$add_wl_txt_clr= sanitize_text_field( $_POST['pwlp_add_wl_text_color']);
		$see_wl_txt_clr= sanitize_text_field( $_POST['pwlp_see_wl_text_color']);
		$pr_add_txtcolor= sanitize_text_field( $_POST['pwlp_pr_add_text_color']);
		$msg_color= sanitize_text_field( $_POST['pwlp_msg_color']);
		$title_wi_page_col= sanitize_text_field( $_POST['pwlp_tit_page']);
		
		$pwlp_style_data=array('add_wl_txt_clr'=>$add_wl_txt_clr,
							'see_wl_txt_clr'=>$see_wl_txt_clr,
							'pr_add_txtcolor'=>$pr_add_txtcolor,'msg_color'=>$msg_color,
							'title_wi_page_col'=>$title_wi_page_col,
						);
		
				
		update_option('data_style_wishlist',$pwlp_style_data);
		 
		}
		
		$pwlp_style_dataa=get_option('data_style_wishlist');
		
		if(!empty($pwlp_style_dataa)){
			extract($pwlp_style_dataa);
		}
		 
		
?>
<h3>Styling Options</h3>
	<table class="form-table">
		<tbody>
		<tr class="user-user-login-wrap">
			<th><label for="pwlp_add_wl_text_color">"Add to Wishlist" text on product page color:</label></th>
			<td><input type="text" class="popup_bg_color" value="<?php if(isset($add_wl_txt_clr)) { echo ($add_wl_txt_clr!='')?$add_wl_txt_clr:'#F3C589' ; }else{echo '#F3C589';}?>" id="pwlp_add_wl_text_color" name="pwlp_add_wl_text_color"></td>
		</tr>
		<tr class="user-user-login-wrap">
			<th><label for="pwlp_see_wl_text_color">"See Wishlist" text on product page color:</label></th>
			<td><input type="text" class="popup_bg_color" value="<?php if(isset($see_wl_txt_clr)) { echo ($see_wl_txt_clr!='')?$see_wl_txt_clr:'#F3C589' ; }else{echo '#F3C589';}?>" id="pwlp_see_wl_text_color" name="pwlp_see_wl_text_color"></td>
		</tr>
		<tr class="user-user-login-wrap">
			<th><label for="pwlp_pr_add_text_color">Text when product added in Wishlist color :</label></th>
			<td><input type="text" class="popup_bg_color" value="<?php if(isset($pr_add_txtcolor)) { echo ($pr_add_txtcolor!='')?$pr_add_txtcolor:'#141412' ; }else{echo '#141412';}?>" id="pwlp_pr_add_text_color" name="pwlp_pr_add_text_color"></td>
		</tr>
		<tr class="user-user-login-wrap">
			<th><label for="pwlp_msg_color">Message color when product is already in wishlist:</label></th>
			<td><input type="text" class="popup_bg_color" value="<?php if(isset($msg_color)) { echo ($msg_color!='')?$msg_color:'#141412' ; }else{echo '#141412';}?>" id="pwlp_msg_color" name="pwlp_msg_color"></td>
		</tr>
		<tr class="user-user-login-wrap">
			<th><label for="pwlp_tit_page">Title on Wishlist page color:</label></th>
			<td><input type="text" class="popup_bg_color" value="<?php if(isset($title_wi_page_col)) { echo ($title_wi_page_col!='')?$title_wi_page_col:'#141412' ; }else{echo '#141412';}?>" id="pwlp_tit_page" name="pwlp_tit_page"></td>
		</tr>
		</tbody>
	</table>
	<input type="submit" value="Save Changes" class="button-primary" name="pwlp_style_setting"  style="float: left; margin-right: 10px;">
</form>