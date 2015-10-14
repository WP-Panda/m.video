<?php
get_header(); ?>
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
						<?php get_template_part('templates/content-templates/blog/blog','post'); ?>
					<div class="blog-pagination wow fadeInUp">
						<?php get_template_part('templates/content-templates/category/pagination'); ?>
					</div><!-- /.pagination -->
				</div><!-- /.col -->

				<div class="col-md-3 sidebar">
					<?php get_sidebar(); ?>
				</div><!-- /.sidebar -->

			</div><!-- /.row -->
		</div><!-- /.container -->
	</div><!-- /.body-content -->
<?php get_footer();