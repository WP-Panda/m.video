<!-- ============================================== HEADER-v7 ============================================== -->
<header>
	<div class="header-v7">
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
					<div class="col-xs-12 col-sm-12 col-md-6 logo">
						<div class="navbar-header">
							<a href="index.php?page=fashion-v1">
								<?php require '../components/header/logo-white.php'; ?>
							</a>
							<button data-target=".mc-horizontal-menu-collapse1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
				                <span class="sr-only">Toggle navigation</span>
				                <span class="icon-bar"></span>
				                <span class="icon-bar"></span>
				                <span class="icon-bar"></span>
				            </button>
			            </div>
					</div>

					<div class="col-xs-8 col-sm-12 col-md-6 search-option">
						<div class="search-bar">
							<?php require '../components/header/option-search-bar.php';?>
							<div class="compare hidden-xs">
								<ul class="list-unstyled">
									<li>
										<a href="#" class="wishlist">
											<i class="fa fa-heart"></i>
										</a>
									</li>
									<li>
										<a href="#" class="compare">
											<i class="fa fa-retweet"></i>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.middle -->

		<div class="bottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-9 col-md-10 navbar">
						<?php require '../components/navigation/navbar.php';?>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-2">
						<div class="dropdown dropdown-cart shopping-cart">
							<?php require '../components/header/cart-style-v7.php'; ?>
							<?php require '../components/header/shopping-cart.php'; ?>
						</div>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.bottom -->
	</div><!-- /.header-v7 -->

</header>
<!-- ============================================== HEADER-v7 : END ============================================== -->