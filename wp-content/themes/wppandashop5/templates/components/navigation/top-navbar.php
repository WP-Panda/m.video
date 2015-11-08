<?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	global $woocommerce;
	$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
	?>
	<div class="top-nav">
		<ul class="list-unstyled list-inline">


			<li class="hidden-xs"><a href="<?php echo home_url('wishlist/') ?>">Список желаний</a></li>
			<?php if ( WC()->cart->get_cart_contents_count() !== 0 ) { ?>
				<li class="hidden-xs"><a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><?php _e('Корзина','wppandashop5'); ?></a></li>
				<li class=""><a href="<?php echo $woocommerce->cart->get_checkout_url(); ?>"><?php _e('Оформление заказа','wppandashop5'); ?></a></li>
			<?php } ?>
			<?php if ( is_user_logged_in() ) { ?>
				<?php if ( $myaccount_page_id ) { ?>
					<li class=""><a href="<?php echo get_permalink( $myaccount_page_id ); ?>"><?php _e('Аккаунт','wppandashop5'); ?></a></li>
				<?php } ?>
				<a href="<?php echo wp_logout_url(); ?>" title="Выход">Выход</a>
			<?php } else { ?>
				<a href="<?php echo wp_login_url(); ?>" title="Войти">Войти</a>
			<?php }; ?>

		</ul>
	</div>
<?php }