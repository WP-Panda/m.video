<?php
/**
 * Show options for ordering
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="col-sm-9 col-md-9 text-right">
	<div class="custom-select">
		<ul class="list-unstyled">
			<li class="short-by">
				<form class="woocommerce-ordering" method="get">
					<select name="orderby" class="orderby styled">
						<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
							<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
						<?php endforeach; ?>
					</select>
					<?php
					// Keep query string vars intact
					foreach ( $_GET as $key => $val ) {
						if ( 'orderby' === $key || 'submit' === $key ) {
							continue;
						}
						if ( is_array( $val ) ) {
							foreach( $val as $innerVal ) {
								echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
							}
						} else {
							echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
						}
					}
					?>
				</form>
			</li>
			<?php //do_action('cr_woocommerce_before_shop_loop'); ?>
		</ul>
	</div>
</div><!-- /.col -->
