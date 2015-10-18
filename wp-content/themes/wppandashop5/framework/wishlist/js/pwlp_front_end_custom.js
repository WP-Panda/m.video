jQuery(document).ready(function(){
		jQuery(".pwlp_share a").jqSocialSharer();
	
});

jQuery(document).on('click','.pwlp_product',pwlp_add_id);
	function pwlp_add_id(){

		var pwlp_product_id = jQuery(this).data("product-id");
		
		jQuery.ajax({
					 
						type : "post",
						dataType : "text",
						url : WishListAjax.ajaxurl,
						data : {action: "pwlp_data_retrive", pwlprod_id:  pwlp_product_id},
						success: function(response){
							jQuery('#pwlp_'+pwlp_product_id).before("<span class='pr_added'>"+text_btn+"</span>");
							jQuery('#pwlp_'+pwlp_product_id).after('<a href="/'+whislist_page_name+'/" target="_blank" class="see_wish">'+see_btn+'</a>');
							jQuery('#pwlp_'+pwlp_product_id).remove();
							
						}
					});
		
			
			
			
	}

jQuery(document).on('click','.pwlp_remove_id',pwlp_remove_id);
	function pwlp_remove_id(){

		var pwlp_remove_id = jQuery(this).data("remove-id");
		
		jQuery.ajax({
					 
						type : "post",
						dataType : "text",
						url : WishListAjax.ajaxurl,
						data : {action: "pwlp_data_remove", pwlpremove_id:  pwlp_remove_id},
						success: function(response) {
							if(response){
								
								jQuery('#pwlp_product_'+response).remove();
							}
						}
					});
		
			
			
			
	}

