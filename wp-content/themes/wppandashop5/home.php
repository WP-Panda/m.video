<?php
get_header(); ?>

	<div class="body-content">
		<div class="container">
			<?php get_template_part('templates/components/section/banner-block'); ?>
			<div class="row blog">

				<?php get_template_part('templates/components/section/news'); ?>
				<?php get_template_part('templates/components/section/banner'); ?>
				<?php get_template_part('templates/components/section/hot'); ?>
				<?php wc_get_template( 'single-product/panda-block/info-list.php' ); ?>

			</div>
		</div>
	</div>
<?php get_footer();