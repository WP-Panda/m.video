<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post wow fadeInUp'); ?>>
	<a class="post-image" href="index.php?page=blog-single"><img class="img-responsive" src="assets/images/blog/1.jpg" alt="#"></a>
	<h1><a href="<?php the_permalink(); ?>" title="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	<span class="author-date">
		<?php printf(__('By %s - %s'),get_the_author(),get_the_date('d.m.Y'));?>
	</span>
	<?php the_excerpt(); ?>
	<a href="<?php the_permalink(); ?>" class="btn btn-upper btn-primary" title="<?php the_permalink(); ?>"><?php _e('read more','wppandashop5'); ?></a>
</div>