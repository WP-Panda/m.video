<a href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" class="dropdown-toggle lnk-cart" title="<?php _e( 'Просмотреть корзину', 'wppandashop5' ); ?>">
	<div class="items-cart-inner">

		<div class="total-price-basket ">

			<span class="cart-icon">

				<i class="fa fa-shopping-cart"></i>

				<span class="mini-basket-amount amount">
					<?php echo wp_kses_data( sprintf( _n( '%d', '%d', WC()->cart->get_cart_contents_count(), 'wppandashop5' ), WC()->cart->get_cart_contents_count() ) );?>
				</span>

			</span>
		</div>

	</div>
</a>