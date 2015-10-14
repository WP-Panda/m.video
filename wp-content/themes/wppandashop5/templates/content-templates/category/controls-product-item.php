<!-- ========================================== CONTROLS PRODUCT ITEM ========================================= -->
<div class="controls-product-item row">
	<div class="col-sm-3 col-md-3">
		<div class="product-item-view">
			<ul class="nav nav-tabs">
				<li><span>View as:</span></li>
				<li class="active"><a data-toggle="tab" href="#grid-container"><i class="icon fa fa-th"></i></a></li>
				<li><a data-toggle="tab" href="#list-container"><i class="icon fa fa-th-list"></i></a></li>
			</ul>
		</div><!-- /.controls-tabs -->
	</div><!-- /.col -->

	<div class="col-sm-5 col-md-6">
		<div class="custom-select">
			<ul class="list-unstyled">
				<li class="short-by">
					<label>Sort by:</label>
		            <select class="styled">
			            <option>Position</option>
			            <option>Low</option>
			            <option>High</option>
			            <option>A to Z</option>
		            </select>
				</li>
				<li class="show-page">
					<label>Show:</label>
		            <select class="styled">
			            <option>1</option>
			            <option>2</option>
			            <option>3</option>
			            <option>4</option>
			            <option>5</option>
			            <option>6</option>
		            </select>
				</li>
			</ul>
		</div>
	</div><!-- /.col -->

	<div class="col col-sm-4 col-md-3">
		<?php get_template_part('templates/content-templates/category/pagination'); ?>
	</div><!-- /.col -->
</div><!-- /.row -->
<!-- ========================================== CONTROLS PRODUCT ITEM : END ========================================= -->