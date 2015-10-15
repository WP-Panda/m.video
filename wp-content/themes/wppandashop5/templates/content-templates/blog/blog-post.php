<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post wow fadeInUp'); ?>>
	<?php if(has_post_thumbnail()) { ?>
		<a class="post-image" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			<?php the_post_thumbnail( array( 'class' => ' img-responsive ',870, 400 ) ); ?>
		</a>
	<?php } ?>
	<h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
	<span class="author-date">
		<?php printf(__('By %s - %s','wppandashop5'),get_the_author(),get_the_date('d.m.Y'));?>
	</span>
	<?php the_excerpt(); ?>
	<a href="<?php the_permalink(); ?>" class="btn btn-upper btn-primary" title="<?php the_title(); ?>"><?php _e('read more','wppandashop5'); ?></a>
</div>