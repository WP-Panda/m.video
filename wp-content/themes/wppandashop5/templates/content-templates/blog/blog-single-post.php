<div class="blog-single-post wow fadeInUp">
	<?php if(has_post_thumbnail()) { ?>
			<?php the_post_thumbnail( array( 'class' => ' img-responsive ',870, 400 ) ); ?>
	<?php } ?>
	<h1><?php the_title(); ?></h1>
	<span class="author-date">
		<?php printf(__('By %s - %s'),get_the_author(),get_the_date('d.m.Y'));?>
	</span>
	<div class="blog-content">
		<?php the_content(); ?>
	</div>

	<div class="cat-tags">
		<span class="cat-links">
			<?php echo get_the_tag_list('<span class="tags-title">' . __('tags:','wppandashop5') .'</span>',', ',''); ?>
		</span>
	</div>
	
	<div class="share">
		<span class="share-title"><?php _e('share:','wppandashop5'); ?></span>
		<a href="#"><i class="fa fa-facebook"></i></a>
		<a href="#"><i class="fa fa-twitter"></i></a>
		<a href="#"><i class="fa fa-google-plus"></i></a>
		<a href="#"><i class="fa fa-tumblr"></i></a>
	</div>

</div>