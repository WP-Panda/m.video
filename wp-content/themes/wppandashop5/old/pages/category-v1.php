<!-- ========================================= CONTENT ========================================= -->
<div class="body-content outer-top-xs">
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

	<div class="container">
		<div class="row category-v1 outer-bottom-sm">
			<div class="col-md-3 col-sm-12 sidebar">
	            <?php require RB_ROOT . '/parts/navigation/sidemenu.php' ?>
	            <h3 class="section-title">shop by</h3>
            	<div class="sidebar-filter">
	            	<?php require RB_ROOT . '/parts/widgets/sidebar/sidebar-manufactures.php' ?>
	            	<?php require RB_ROOT . '/parts/widgets/sidebar/sidebar-price-slider.php' ?>
	            	<?php require RB_ROOT . '/parts/widgets/sidebar/sidebar-color.php' ?>
	            </div><!-- /.sidebar-filter -->

	            	<?php get_template_part('templates/components/sidebar/product-tags'); ?>
	            	<?php require RB_ROOT . '/parts/widgets/sidebar/sidebar-comparision.php' ?>
	            	<?php require RB_ROOT . '/parts/widgets/sidebar/sidebar-advertisement.php' ?>
	            	
            </div><!-- /.sidebar -->

            
			<div class=" col-md-9 col-sm-12 outer-bottom-sm">

				<?php require RB_ROOT . '/parts/section/category/category-page-slider.php' ?>

				<div class="controls-product-top outer-top-vs wow fadeInUp">
					<?php require RB_ROOT . '/parts/section/category/controls-product-item.php' ?>
				</div><!-- /.controls-product-top -->

				<div class="search-result-container">
					<div id="myTabContent" class="tab-content">
						<div class="tab-pane active " id="grid-container">
							<div class="category-product  inner-top-xs">
								<div class="row">		

									<?php require RB_ROOT . '/parts/section/category/category-v1-grid.php'; ?>
									
								</div><!-- /.row -->
							</div><!-- /.category-product -->
						
						</div><!-- /.tab-pane -->
							
						<div class="tab-pane outer-top-vs"  id="list-container">
							<div class="category-product ">

								<?php require RB_ROOT . '/parts/section/category/category-v1-list.php'; ?>

							</div><!-- /.category-product -->
						</div><!-- /.tab-pane #list-container -->
					</div><!-- /.tab-content -->
					
					<div class="clearfix controls-product-bottom wow fadeInUp">
						
						<?php require RB_ROOT . '/parts/section/category/controls-product-item.php' ?>
						
					</div><!-- /.filters-container -->

				</div><!-- /.search-result-container -->

			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container -->

</div><!-- /.body-content -->
<!-- ========================================= CONTENT : END========================================= -->