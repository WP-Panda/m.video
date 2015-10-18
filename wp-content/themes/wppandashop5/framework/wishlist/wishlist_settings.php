<?php 

	function wishlist_settings(){
		
	?>
	<div>
		<?php $pwlp_tabs = sanitize_text_field( $_GET['pwlp_tabs'] );	?>
		<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
			<a class="nav-tab <?php if($pwlp_tabs == 'gen' || $pwlp_tabs == ''){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=pwlp-wishlist-manager&amp;pwlp_tabs=gen">General</a>
			<a class="nav-tab <?php if($pwlp_tabs == 'share'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=pwlp-wishlist-manager&amp;pwlp_tabs=share">Share Settings</a>
			<a class="nav-tab <?php if($pwlp_tabs == 'style'){ echo esc_html( "nav-tab-active" ); } ?>" href="?page=pwlp-wishlist-manager&amp;pwlp_tabs=style">Style Settings</a>
			

		</h2>
		<?php 
			if($pwlp_tabs == 'gen' || $pwlp_tabs == ''){ 
				
				require_once('pwlp_genral.php');
				
			}
			if($pwlp_tabs == 'share' ){
				
				require_once('pwlp_share_setting.php');	
			
			}
			
			if($pwlp_tabs == 'style' ){
				
				require_once('pwlp_style_setting.php');
				
			}
			
		?>
	</div>
	
	<?php 
	}
	
?>