<?php global $wps5_option;
$logo = $wps5_option['custom_admin_logo'];
$text = ! empty( $wps5_option['h_t'] ) ? $wps5_option['h_t'] : '+38 099 454 43 30'?>
<header>
	<div class="header-v2">
		<div class="top">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-5 top-bar">
						<span class="welcome-msg hidden-xs"><?php echo $text ?></span>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-7 top-navbar">
						<?php get_template_part('templates/components/navigation/top-navbar'); ?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.top -->

		<div id="fixer" class="middle">
			<div class="container">
				<div class="row">

					<div class="col-xs-4 col-sm-5 col-md-2">
						<div class="navbar-header">
							Войтить
						</div>
					</div>

					<div class="col-xs-8 col-sm-7 col-md-5 logo">
						<div class="navbar-header">
								<?php
								if( ! empty( $logo ) ) {
									echo '<a href="' . home_url() . '" alt="' . get_bloginfo('name'). '"><img class="logo" src="' . $logo['url'] . '" title="' . get_bloginfo('name'). '"></a>';
								} else {
									get_template_part('templates/components/header/logo', '');
								}
								 ?>
							<?php /* button data-target=".mc-horizontal-menu-collapse1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button */ ?>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-3">
						<?php get_template_part('templates/components/header/option-search-bar'); ?>
					</div>

					<div class="col-xs-6 col-sm-6 col-md-1 text-right">
						<?php if ( is_woocommerce_activated() ) { ?>
								<i class="fa fa-heart"></i>
						<?php } ?>
					</div>

					<div class="col-xs-6 col-sm-6 col-md-1">
						<?php if ( is_woocommerce_activated() ) { ?>
							<div id="cart-drop" class="dropdown dropdown-cart shopping-cart">
								<?php get_template_part('templates/components/header/cart-style','v2'); ?>
								<?php get_template_part('templates/components/header/shopping-cart'); ?>
							</div>
						<?php } ?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.middle -->

		<div class="bottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 navbar">
						<?php get_template_part('templates/components/navigation/navbar',''); ?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.bottom -->



	</div><!-- /.header-v2 -->

</header>
<!-- ============================================== HEADER-v2 : END ============================================== -->