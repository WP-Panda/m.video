<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	global $woocommerce;
	$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
	?>
	<div class="top-nav">
		<ul class="list-unstyled list-inline">
			<?php if ( $myaccount_page_id ) { ?>
				<li class=""><a href="<?php echo get_permalink( $myaccount_page_id ); ?>"><?php _e('My Account','wppandashop5'); ?></a></li>
			<?php } ?>
			<!--li class="hidden-xs"><a href="#">Wishlist</a></li-->
			<li class="hidden-xs"><a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><?php _e('My Cart','wppandashop5'); ?></a></li>
			<?php if ( WC()->cart->get_cart_contents_count() !== 0 ) { ?>
				<li class=""><a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>"><?php _e('Checkout','wppandashop5'); ?></a></li>
			<?php } ?>
			<li class=""><a href="#">Login</a></li>
		</ul>
	</div>
<?php }