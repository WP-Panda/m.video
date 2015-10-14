<!-- ============================================== HEADER-v5 ============================================== -->
<header>
	<div class="header-v5">
		<div class="top">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 top-bar">
						<div class="language-currency">
							<?php require '../components/header/language-currency.php'; ?>
						</div>
						<span class="welcome-msg hidden-xs">Default welcome msg!</span>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 top-navbar">
						<?php require '../components/navigation/top-navbar.php';?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.top -->

		<div class="middle">
			<div class="container">
				<div class="row">

					<div class="col-xs-12 col-sm-12 col-md-4">
						<?php require '../components/header/option-search-bar.php';?>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-5 logo">
						<div class="navbar-header">
							<a href="index.php?page=fashion-v1" class="navbar-brand">
								<?php require '../components/header/logo.php'; ?>
							</a>
							<button data-target=".mc-horizontal-menu-collapse1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
				                <span class="sr-only">Toggle navigation</span>
				                <span class="icon-bar"></span>
				                <span class="icon-bar"></span>
				                <span class="icon-bar"></span>
				            </button>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-3">
						<div class="dropdown dropdown-cart shopping-cart">
							<?php require '../components/header/cart-style-v2.php'; ?>
							<?php require '../components/header/shopping-cart.php'; ?>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.middle -->

		<div class="bottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 navbar">
						<?php require '../components/navigation/navbar.php';?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.bottom -->
	</div><!-- /.header-v5 -->

</header>
<!-- ============================================== HEADER-v5 : END ============================================== -->