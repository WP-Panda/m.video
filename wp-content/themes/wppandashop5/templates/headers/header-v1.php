<!-- ============================================== HEADER-v1 ============================================== -->
<header>
	
	<div class="header-v1">
		<div class="top">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 top-bar">
						<span class="welcome-msg">Default welcome msg!</span>
						<span class="customer-care-info hidden-xs"><i class="fa fa-phone"></i> Call for free +1868 123 456</span>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 top-navbar">
						<?php get_template_part('templates/components/navigation/top','navbar');?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.top -->

		<div class="middle">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-4">
						<?php get_template_part('templates/components/header/option','search-bar');?>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-4 logo">
						<div class="navbar-header">
							<a href="index.php?page=fashion-v1" class="navbar-brand">
								<?php get_template_part('templates/components/header','logo'); ?>
							</a>
							<button data-target=".mc-horizontal-menu-collapse1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
				                <span class="sr-only">Toggle navigation</span>
				                <span class="icon-bar"></span>
				                <span class="icon-bar"></span>
				                <span class="icon-bar"></span>
				            </button>
			            </div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-2 hidden-xs">
						<div class="language-currency">
							<?php get_template_part('templates/components/header/language','currency.php'); ?>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-2">
						<div class="dropdown dropdown-cart shopping-cart">
							<?php get_template_part('templates/components/header/cart-style','v1.php'); ?>
							<?php get_template_part('templates/components/header/shopping','cart.php'); ?>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.middle -->

		<div class="bottom">
			<div class="container">
				<div class="navbar">
					<?php get_template_part('templates/components/navigation/navbar',''); ?>
				</div>
			</div><!-- /.container -->
		</div><!-- /.bottom -->
	</div><!-- /.header-v1 -->
	
</header>
<!-- ============================================== HEADER-v1 : END ============================================== -->