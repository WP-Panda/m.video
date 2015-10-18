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

<div class="body-content details-v1">
	<div class="container">
		<div class="row">
			
			<div class='col-md-3 sidebar wow fadeInUp'>
	            <?php require <?php get_template_part('templates/components/navigation/sidemenu'); ?> ?>
	            <div class="sidebar-module-container">
	            	<div class="related-product clearfix">
		            	<?php require RB_ROOT . '/parts/widgets/sidebar/related-products.php' ?>
		            	<?php get_template_part('templates/components/sidebar/sidebar','advertisement'); ?>
	            	</div><!-- /.sidebar-filter -->
	            </div><!-- /.sidebar-module-container -->
            </div><!-- /.sidebar -->

           	<div class="col-md-9 details-page">

           		<?php require RB_ROOT . '/parts/section/detail/product-details.php' ?>

           		<div class="up-sell-products wow fadeInUp">
					<?php require RB_ROOT . '/parts/section/detail/upsell-products.php'; ?>
				</div><!-- /.up-sell-products -->
           	</div> <!-- /.details-page -->          	
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /.body-content -->
<!-- ========================================= CONTENT : END========================================= -->
