<!-- ========================================= CONTENT ========================================= -->
<div class="breadcrumb">
	<div class="container">
		<div class="breadcrumb-inner">
			<ul class="list-inline list-unstyled">
				<li><a href="#">Home</a></li>
				<li class='active'>Blog</li>
			</ul>
		</div><!-- /.breadcrumb-inner -->
	</div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
	<div class="container">
		<div class="row blog">
			<div class="col-md-9">
				<?php require RB_ROOT . '/parts/section/blog/blog-single-post.php' ?>
				<?php require RB_ROOT . '/parts/section/blog/blog-comments.php' ?>
				<?php require RB_ROOT . '/parts/section/blog/blog-write-comments.php' ?>
			</div><!-- /.col -->

			<div class="col-md-3 sidebar">
				<?php require RB_ROOT . '/parts/widgets/sidebar/blog-category.php' ?>
				<?php require RB_ROOT . '/parts/widgets/sidebar/recent-post.php' ?>
				<?php require RB_ROOT . '/parts/widgets/sidebar/archive.php' ?>
				<?php require RB_ROOT . '/parts/widgets/sidebar/product-tags.php' ?>
				<?php require RB_ROOT . '/parts/widgets/sidebar/gallery.php' ?>
			</div><!-- /.sidebar -->
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /.body-content -->
<!-- ========================================= CONTENT : END ========================================= -->