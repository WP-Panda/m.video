<!-- ============================================== HEADER-v9 ============================================== -->
<header>
	<div class="header-v9">
		<div class="top">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 top-bar">
						<div class="language-currency">
							<?php require RB_ROOT.'/parts/widgets/header/language-currency.php'; ?>
						</div>
						<span class="customer-care-info hidden-xs"><i class="fa fa-phone"></i> Call for free +1868 123 456</span>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-6 top-navbar">
						<?php require RB_ROOT.'/parts/navigation/top-navbar.php';?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.top -->

		<div class="fashion-v4">
			<?php require RB_ROOT.'/parts/section/fashion/fashion-v4-slider.php' ?>
		</div>

		<div class="middle">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-4 logo">
						<div class="navbar-header">
							<a href="index.php?page=fashion-v1" class="navbar-brand">
								<?php require RB_ROOT.'/parts/widgets/header/logo.php'; ?>
							</a>
							<button data-target=".mc-horizontal-menu-collapse1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
				                <span class="sr-only">Toggle navigation</span>
				                <span class="icon-bar"></span>
				                <span class="icon-bar"></span>
				                <span class="icon-bar"></span>
				            </button>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-5 search-option">
						<?php require RB_ROOT.'/parts/widgets/header/option-search-bar.php';?>
					</div>
				
					<div class="col-xs-12 col-sm-12 col-md-3">
						<div class="dropdown dropdown-cart shopping-cart">
							<?php require RB_ROOT.'/parts/widgets/header/cart-style-v2.php'; ?>
							<?php require RB_ROOT.'/parts/widgets/header/shopping-cart.php'; ?>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.middle -->

		<div class="bottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 navbar">
						<?php require RB_ROOT.'/parts/navigation/navbar.php';?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.bottom -->

	</div><!-- /.header-v9 -->

</header>
<!-- ============================================== HEADER-v9 : END ============================================== -->

