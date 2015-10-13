<!-- ========================================= CONTENT ========================================= -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">Home</a></li>
				<li class='active'>Shopping cart</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
	<div class="container shopping-cart">
		<?php require RB_ROOT.'/parts/section/shopping-cart-summary/shopping-cart.php' ?>
		<div class="row wow fadeInUp">
			<?php require RB_ROOT.'/parts/section/shopping-cart-summary/estimate-ship-tax.php' ?>
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /.body-content -->
<!-- ========================================= CONTENT : END========================================= -->