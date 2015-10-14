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
				<?php get_template_part('templates/content-templates/blog','single-post'); ?>
				<?php get_template_part('templates/content-templates/blog','comments'); ?>
				<?php get_template_part('templates/content-templates/blog','write-comments'); ?>
			</div><!-- /.col -->

			<div class="col-md-3 sidebar">
				<?php get_template_part('templates/components/sidebar/blog-category'); ?>
				<?php get_template_part('templates/components/sidebar/recent-post'); ?>
				<?php get_template_part('templates/components/sidebar/archive'); ?>
				<?php get_template_part('templates/components/sidebar/product-tags'); ?>
				<?php get_template_part('templates/components/sidebar/gallery'); ?>
			</div><!-- /.sidebar -->
		</div><!-- /.row -->
	</div><!-- /.container -->
</div><!-- /.body-content -->
<!-- ========================================= CONTENT : END ========================================= -->