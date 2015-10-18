<?php 
if($_POST['pwlp_share_setting']){
			
			
		$share_fb= sanitize_text_field( $_POST['pwlp_share_fb'] );
		$share_gp= sanitize_text_field( $_POST['pwlp_share_gp'] );
		$share_pin= sanitize_text_field( $_POST['pwlp_share_pin'] );
		$share_twt= sanitize_text_field( $_POST['pwlp_share_twt'] );
		$tit_social_net= sanitize_text_field( $_POST['pwlp_tit_social_net'] );
		$pwlp_msg_text= sanitize_text_field( $_POST['pwlp_msg_text']);
		
		
		$pwlp_share_data=array('share_fb'=>$share_fb,'share_gp'=>$share_gp,
								'share_pin'=>$share_pin,'share_twt'=>$share_twt,'tit_social_net'=>$tit_social_net,
								'pwlp_msg_text'=>$pwlp_msg_text,
								);
		
				
		update_option('data_share_wishlist',$pwlp_share_data);
		 
		}
		
		$pwlp_share_dataa=get_option('data_share_wishlist');
		
		if(!empty($pwlp_share_dataa)){
			extract($pwlp_share_dataa);
		}
		 
		
?>
<form method="post" class="pwlp_share_setting">
<h3>Share Options</h3>
	<table class="form-table">
		<tbody>
		<tr valign="top" class="">
				<th class="titledesc" scope="row">Share on Facebook</th>
				<td class="forminp forminp-checkbox">
					<fieldset>
						<label for="pwlp_share_fb">
							<input type="checkbox"  value="1" <?php if(isset($share_fb)){ echo ($share_fb==1)?'checked':'' ;}else{ echo 'checked';}?> class="" id="pwlp_share_fb" name="pwlp_share_fb"></label> 
					</fieldset>
				</td>
			</tr>
			<tr valign="top" class="">
				<th class="titledesc" scope="row">Share on Google+</th>
				<td class="forminp forminp-checkbox">
					<fieldset>
						<label for="pwlp_share_gp">
							<input type="checkbox"  value="1" <?php if(isset($share_gp)){ echo ($share_gp==1)?'checked':'' ;}else{ echo 'checked';}?> class="" id="pwlp_share_gp" name="pwlp_share_gp"></label> 
					</fieldset>
				</td>
			</tr>
			<tr valign="top" class="">
				<th class="titledesc" scope="row">Share on Pintrest</th>
				<td class="forminp forminp-checkbox">
					<fieldset>
						<label for="pwlp_share_pin">
							<input type="checkbox"  value="1" <?php if(isset($share_pin)){ echo ($share_pin==1)?'checked':'' ;}else{ echo 'checked';}?> class="" id="pwlp_share_pin" name="pwlp_share_pin"></label> 
					</fieldset>
				</td>
			</tr>
			<tr valign="top" class="">
				<th class="titledesc" scope="row">Share on Twitter</th>
				<td class="forminp forminp-checkbox">
					<fieldset>
						<label for="pwlp_share_twt">
							<input type="checkbox"  value="1" <?php if(isset($share_twt)){ echo ($share_twt==1)?'checked':'' ;}else{ echo 'checked';}?> class="" id="pwlp_share_twt" name="pwlp_share_twt"></label> 
					</fieldset>
				</td>
			</tr>
			
			<tr valign="top">
				<th class="titledesc" scope="row">
					<label for="pwlp_tit_social_net">Title display on Social networks </label>
				</th>
				<td class="forminp forminp-text">
					<input type="text" size="60" value="<?php if(isset($tit_social_net)){  echo ($tit_social_net!='')?$tit_social_net:'Share On:'; }else{ echo 'Share On:';}?>" style="" id="pwlp_tit_social_net" name="pwlp_tit_social_net" >					
				</td>
			</tr>
			
			<tr valign="top">
				<th class="titledesc" scope="row">
					<label for="pwlp_msg_text">Message text</label>
				</th>
				<td class="forminp forminp-text">
					<input type="text" size="60" value="<?php if(isset($pwlp_msg_text)){  echo ($pwlp_msg_text!='')?$pwlp_msg_text:'Share it'; }else{echo 'Share it';}?>" style="" id="pwlp_msg_text" name="pwlp_msg_text" >					
				</td>
			</tr>
		</tbody>
	</table>
	<input type="button" name="share_reset_value" id="share_reset_value" value="Reset" class="button button-info" style="float: left; margin-right: 10px;">
	<input type="submit" value="Save Changes" class="button-primary" name="pwlp_share_setting"  style="float: left; margin-right: 10px;">
</form>