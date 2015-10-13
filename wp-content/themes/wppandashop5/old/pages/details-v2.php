<!-- ========================================= CONTENT ========================================= -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">Home</a></li>
				<li><a href="#">Womens</a> </li>
				<li class='active'>Product Name #01</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
	<div class="container">
		<div class="row details-v2">
			<div class="col-md-9 details-page">
           		<?php require RB_ROOT . '/parts/section/detail/product-details.php' ?>
           	</div>

			<div class='col-md-3 sidebar'>
	            <div class="sidebar-module-container">
	            	<div class="related-product wow fadeInUp">
	            		
        			<?php require RB_ROOT . '/parts/widgets/sidebar/sidebar-single-product.php'; ?>
        		
            		<?php require RB_ROOT . '/parts/widgets/sidebar/sidebar-advertisement.php' ?>
		            	
	            	</div><!-- /.sidebar-filter -->
	            </div><!-- /.sidebar-module-container -->
            </div><!-- /.sidebar -->
           	 
           	<div class="col-md-12 col-sm-12 up-sell-products wow fadeInUp">
				<?php require RB_ROOT . '/parts/section/detail/upsell-products-v1.php'; ?>
			</div><!-- /.up-sell-products -->
		</div><!-- /.details-v2 -->
	</div><!-- /.container -->
</div><!-- /.body-content -->
<!-- ========================================= CONTENT : END========================================= -->
