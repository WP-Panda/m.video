<!-- ========================================= CONTENT ========================================= -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">Home</a></li>
				<li class='active'>Women's</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content outer-top-xs ">
	<div class="container">
		<div class="row outer-bottom-sm category-v3">
			<div class='col-md-12'>

				<div class="filter-container wow fadeInUp">
					<?php require RB_ROOT . '/parts/section/category/filter-container.php' ?>
				</div><!-- /.filter-container -->

				<div class="controls-product-top outer-top-vs wow fadeInUp">
					<?php require RB_ROOT . '/parts/section/category/controls-product-item.php' ?>
				</div><!-- /.controls-product-top -->

				<div class="search-result-container">
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane active " id="grid-container">
							<div class="category-product  inner-top-xs">
								<div class="row">									

									<?php require RB_ROOT . '/parts/section/category/category-v3-grid.php'; ?>
									
								</div><!-- /.row -->
							</div><!-- /.category-product -->
						
						</div><!-- /.tab-pane -->
							
						<div class="tab-pane outer-top-vs"  id="list-container">
							<div class="category-product  ">

								<?php require RB_ROOT . '/parts/section/category/category-v3-list.php'; ?>

							</div><!-- /.category-product -->
						</div><!-- /.tab-pane #list-container -->
					</div><!-- /.tab-content -->
					<div class="clearfix controls-product-bottom">
						
						<?php require RB_ROOT . '/parts/section/category/controls-product-item.php' ?>
						
					</div><!-- /.filters-container -->

				</div><!-- /.search-result-container -->

			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /.body-content -->
<!-- ========================================= CONTENT : END========================================= -->