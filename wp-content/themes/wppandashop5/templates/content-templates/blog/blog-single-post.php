<div class="blog-single-post	">

	<?php if(has_post_thumbnail()) { ?>
		<?php the_post_thumbnail( array( 'class' => ' img-responsive ',870, 400 ) ); ?>
	<?php } ?>
	<h1><?php the_title(); ?></h1>
	<?php if ( ! is_page()) { ?>
		<span class="author-date">
			<?php printf(__('By %s - %s','wppandashop5'),get_the_author(),get_the_date('d.m.Y'));?>
		</span>
	<?php } ?>
	<div class="blog-content">
		<?php the_content(); ?>
	</div>

	<div class="cat-tags">
		<span class="cat-links">
			<?php echo get_the_tag_list('<span class="tags-title">' . __('tags:','wppandashop5') .'</span>',', ',''); ?>
		</span>
	</div>

</div>