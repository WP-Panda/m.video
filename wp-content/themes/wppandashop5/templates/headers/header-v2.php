<!-- ============================================== HEADER-v2 ============================================== -->
<header>
	<div class="header-v2">
		<div class="top">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 top-bar">
						<span class="welcome-msg hidden-xs">Default welcome msg!</span>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 top-navbar">
						<?php get_template_part('templates/components/navigation/top-navbar'); ?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.top -->

		<div class="middle">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-4 logo">
						<div class="navbar-header">
							<a href="index.php?page=fashion-v1" class="navbar-brand">
								<?php get_template_part('templates/components/header/logo',''); ?>
							</a>
							<button data-target=".mc-horizontal-menu-collapse1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
				                <span class="sr-only">Toggle navigation</span>
				                <span class="icon-bar"></span>
				                <span class="icon-bar"></span>
				                <span class="icon-bar"></span>
				            </button>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-5">
						<?php get_template_part('templates/components/header/option-search-bar'); ?>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-3">
						<div class="dropdown dropdown-cart shopping-cart">
							<?php get_template_part('templates/components/header/cart-style','v2'); ?>
							<?php get_template_part('templates/components/header/shopping-cart'); ?>
						</div>
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