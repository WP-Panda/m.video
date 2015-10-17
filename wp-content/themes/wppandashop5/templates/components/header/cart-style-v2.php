<a href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" class="dropdown-toggle lnk-cart" title="<?php _e( 'View your shopping cart', 'wppandashop5' ); ?>">
	<div class="items-cart-inner">

		<div class="total-price-basket ">
			<span class="cart-icon"><i class="fa fa-shopping-cart"></i></span>
			<span class="cart-info">
				<span class="label-name"><?php _e('shopping cart','wppandashop5');?></span>
				<span class="cart-count">
					<?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?>
					<span class="amount">
						<?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'wppandashop5' ), WC()->cart->get_cart_contents_count() ) );?>
					</span>
				</span>
			</span>
		</div>

	</div>
</a>