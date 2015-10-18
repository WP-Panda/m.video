jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery(".popup_bg_color").wpColorPicker();
	jQuery('#pwlp_wishlist_page').select2();
	
});
jQuery(document).on('click','#reset_value',reset_all);
function reset_all(){
	
		jQuery('#pwlp_plugin_enable').prop('checked', true);
		jQuery('#pwlp_titl_wishlist_page').val(whislist_title);
		jQuery('#pwlp_add_to_cart_red').prop('checked', false);
		jQuery('#pcp_remove_from_wishlist').prop('checked', false);
		jQuery('#pwlp_wishlist_text_product_page').val('Add to Wishlist');
		jQuery('#pwlp_see_wishlist_text_product_page').val('See WishList');
		jQuery('#pwlp_text_in_added').val('Added');
		jQuery('#pwlp_msg_in_already').val('The product is already in the wishlist!');
		jQuery('#pwlp_adding_date_wishlist').prop('checked', false);
		
	}	
jQuery(document).on('click','#share_reset_value',share_reset_all);
function share_reset_all(){
	
	
		jQuery('#pwlp_share_fb').prop('checked', true);
		jQuery('#pwlp_share_gp').prop('checked', true);
		jQuery('#pwlp_share_pin').prop('checked', true);
		jQuery('#pwlp_share_twt').prop('checked', true);
		jQuery('#pwlp_tit_social_net').val('Share On:');
		jQuery('#pwlp_msg_text').val('Share it');
		
		
	}

