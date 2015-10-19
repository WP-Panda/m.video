jQuery.noConflict();
jQuery(document).ready(function(){
	
		jQuery(".pcpcompare").click(function() {
				var pcp_product_id = jQuery(this).data("custom-value");
				jQuery('product_id').val(pcp_product_id);
				//jQuery('#colorbox').addClass("pcp_com");
			});
		
});
jQuery(document).on('click','.compare_shop_popup',compare_prod);
function compare_prod(){
	var product_idd = jQuery(this).data('value');
	jQuery(this).text('Added');
	jQuery( this ).addClass( "added" );
	
	
	jQuery.ajax({
         type : "post",
         dataType : "text",
         url : CompareAjax.ajaxurl,
         data : {action: "pcp_data_retrive", prod_id:  product_idd},
         success: function(response) {
           
			jQuery.colorbox({className: 'pcpl_com',inline:true, width:"90%" , height:"90%",href:"#pcpinline_content"});
			
			jQuery('.tabel_data').html(response);
			
			var count_table= jQuery('.compare_item').length ;
			var compare_div_width=count_table*260;
			
			var compare_image_hight=jQuery('.compare_prod_image').height();
			var compare_image_hight2=jQuery('.compare_text_image').height();
			
			if(compare_image_hight>compare_image_hight2){
				jQuery('.compare_text_image').height(compare_image_hight);
			}else{
				jQuery('.compare_prod_image').height(compare_image_hight2);
			}
			
			var compare_desc_hight=jQuery('.compare_prod_desc').height();
			var compare_desc_hight2=jQuery('.compare_text_desc').height();
			
			if(compare_desc_hight>compare_desc_hight2){
				jQuery('.compare_text_desc').height(compare_desc_hight);
			}else{
				jQuery('.compare_prod_desc').height(compare_desc_hight2);
			}
			
			var compare_title_hight=jQuery('.compare_prod_tit').height();
			var compare_title_hight2=jQuery('.compare_text_tit').height();
			
			if(compare_title_hight>compare_title_hight2){
					jQuery('.compare_text_tit').height(compare_title_hight);
			}else{
				jQuery('.compare_prod_tit').height(compare_title_hight2);
			}
			
			jQuery('.tabel_data').width(compare_div_width);
         }
      });   

}
jQuery(document).on('click','.compare_product_popup',compare_prod1);
function compare_prod1(){
	var product_idd = jQuery(this).data('value');
	jQuery(this).text('Added');
	jQuery( this ).addClass( "added" );
	jQuery.ajax({
         type : "post",
         dataType : "text",
         url : CompareAjax.ajaxurl,
         data : {action: "pcp_data_retrive", prod_id:  product_idd},
         success: function(response) {
			jQuery.colorbox({className: 'pcpl_com',inline:true, width:"90%" , height:"90%",href:"#pcpinline_content"});
			
			jQuery('.tabel_data').html(response);
			
			var count_table= jQuery('.compare_item').length ;
			var compare_div_width=count_table*260;
			
			var compare_image_hight=jQuery('.compare_prod_image').height();
			var compare_image_hight2=jQuery('.compare_text_image').height();
			
			if(compare_image_hight>compare_image_hight2){
				jQuery('.compare_text_image').height(compare_image_hight);
			}else{
				jQuery('.compare_prod_image').height(compare_image_hight2);
			}
			
			var compare_desc_hight=jQuery('.compare_prod_desc').height();
			var compare_desc_hight2=jQuery('.compare_text_desc').height();
			
			if(compare_desc_hight>compare_desc_hight2){
				jQuery('.compare_text_desc').height(compare_desc_hight);
			}else{
				jQuery('.compare_prod_desc').height(compare_desc_hight2);
			}
			
			var compare_title_hight=jQuery('.compare_prod_tit').height();
			var compare_title_hight2=jQuery('.compare_text_tit').height();
			
			if(compare_title_hight>compare_title_hight2){
					jQuery('.compare_text_tit').height(compare_title_hight);
			}else{
				jQuery('.compare_prod_tit').height(compare_title_hight2);
			}
			
			jQuery('.tabel_data').width(compare_div_width);
         }
      });
	 	  

	
}
jQuery(document).on('click','.remove_product_id',pcp_remove_product);
function pcp_remove_product(){
	var remove_product_id=jQuery(this).data('value');
	jQuery.ajax({
         type : "post",
         dataType : "text",
         url : CompareAjax.ajaxurl,
         data : {action: "pcp_product_id_remove", remove_prod_id:  remove_product_id},
         success: function(response) {
			jQuery.colorbox({inline:true, width:"90%" , height:"90%",href:"#pcpinline_content"});
			var div_width=jQuery('.tabel_data').width();
			div_width=div_width-260;
			jQuery('.tabel_data').width(div_width);
			jQuery('.tabel_data').html(response);
         }
      });   
}


	
	
	
