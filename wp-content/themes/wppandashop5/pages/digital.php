<!-- ========================================= CONTENT ========================================= -->
<div class="body-content inner-top-vs">
	<div class="digital">

		<div class="container category-product">
			<div class="row">
				<div class="col-md-3 sidebar">
					<?php require RB_ROOT. '/parts/navigation/sidebar/digital-menu-vertical.php'; ?>
				</div>
				<div class="col-md-9 slider">
					<?php require RB_ROOT.'/parts/section/digital/digital-slider.php' ?>
				</div>
				<div class="clearfix"></div>
				<?php require RB_ROOT.'/parts/section/digital/digital-banner.php' ?>
			</div><!-- /.row -->
		</div><!-- /.container -->

		<div class="container category-product">
			<div class="row">
				<?php require RB_ROOT.'/parts/section/digital/featured-products-digital.php'; ?>				
			</div><!-- /.row -->

			<?php require RB_ROOT.'/parts/section/digital/digital-banner-mini.php';?>
		</div><!-- /.container -->

		<?php require RB_ROOT. '/parts/section/digital/blog-slider-full-digital.php'; ?>

		<div class="container category-product wow fadeInUp">
			<div class="row">

				<?php require RB_ROOT.'/parts/widgets/sidebar/digital-by-category.php' ?>
				
				<div class="col-md-3 wow fadeInUp" data-wow-delay="0.2s">
					<?php require RB_ROOT. '/parts/section/digital/digital-special-offer.php'; ?>
				</div>
				<div class="col-md-3 wow fadeInUp" data-wow-delay="0.4s">
					<?php require RB_ROOT. '/parts/section/digital/digital-new-arrivals.php'; ?>
				</div>
				<div class="col-md-3 wow fadeInUp" data-wow-delay="0.6s">
					<?php require RB_ROOT. '/parts/section/digital/digital-best-seller.php'; ?>
				</div>
				
			</div><!-- /.row -->
		</div><!-- /.container -->

		<?php require RB_ROOT. '/parts/section/news-letter-full.php'; ?>

		<div class="container category-product digital-single wow fadeInUp">
			<div class="row">
				<div class="col-md-12 featured-products">
					<h3 class="section-title">weekly featured</h3>
					<?php require RB_ROOT.'/parts/product/digital-new-products.php'; ?>
				</div><!-- /.col -->

				<?php require RB_ROOT. '/parts/section/our-brands-v2.php'; ?>
				
			</div><!-- /.row -->
		</div><!-- /.container -->

	</div><!-- /.digital -->
</div><!-- /.body-content -->
<!-- ========================================= CONTENT : END========================================= -->