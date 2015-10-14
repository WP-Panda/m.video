<?php
get_header(); ?>
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
				<?php require 'templates/content-templates/blog/blog-post.php' ?>
<div class="blog-pagination wow fadeInUp">
    <?php require 'templates/content-templates/category/pagination.php' ?>

</div><!-- /.pagination -->
</div><!-- /.col -->

<div class="col-md-3 sidebar">
    <?php require 'templates/components/sidebar/blog-category.php' ?>
    <?php require 'templates/components/sidebar/recent-post.php' ?>
    <?php require 'templates/components/sidebar/archive.php' ?>
    <?php require 'templates/components/sidebar/product-tags.php' ?>
    <?php require 'templates/components/sidebar/gallery.php' ?>
</div><!-- /.sidebar -->
</div><!-- /.row -->
</div><!-- /.container -->
</div><!-- /.body-content -->
<!-- ========================================= CONTENT : END========================================= -->
<?php get_footer();