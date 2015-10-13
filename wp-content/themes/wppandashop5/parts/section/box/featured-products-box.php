<!-- ============================================== FEATURED PRODUCTS BOX ============================================== -->
<div class="featured-products">
	<h3 class="section-title">featured</h3>
	<div role="tabpanel">

		<!-- Nav tabs -->
		<ul class="nav nav-tabs box-product-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#new" aria-controls="new" role="tab" data-toggle="tab">new</a></li>
			<li role="presentation"><a href="#featured" aria-controls="featured" role="tab" data-toggle="tab">featured</a></li>
			<li role="presentation"><a href="#sale" aria-controls="sale" role="tab" data-toggle="tab">sale</a></li>
			<li class="hidden-xs" role="presentation"><a href="#special" aria-controls="special" role="tab" data-toggle="tab">special</a></li>
		</ul><!-- /.nav-tabs -->

		<!-- Tab panes -->
		<div class="tab-content">

			<div role="tabpanel" class="tab-pane fade in active" id="new">
				<?php require RB_ROOT.'/parts/product/box-new-products.php'; ?>
			</div>

			<div role="tabpanel" class="tab-pane fade" id="featured">
				<?php require RB_ROOT.'/parts/product/box-featured-products.php'; ?>
			</div>

			<div role="tabpanel" class="tab-pane fade" id="sale">
				<?php require RB_ROOT.'/parts/product/box-featured-products.php'; ?>
			</div>

			<div role="tabpanel" class="tab-pane fade" id="special">
				<?php require RB_ROOT.'/parts/product/box-featured-products.php'; ?>
			</div>

		</div><!-- /.tab-content -->

	</div><!-- /tabpanel -->
</div><!-- /.featured-products -->
<!-- ============================================== FEATURED PRODUCTS BOX : END ============================================== -->