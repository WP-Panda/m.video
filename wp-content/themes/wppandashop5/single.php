<?php
get_header(); ?>

<?php get_template_part('templates/components/header/breadcrumb'); ?>

    <div class="body-content">
        <div class="container">
            <div class="row blog">

                <div class="col-md-9">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part('templates/content-templates/blog/blog','single-post'); ?>
                        <?php get_template_part('templates/content-templates/blog/blog','comments'); ?>
                        <?php get_template_part('templates/content-templates/blog/blog','write-comments'); ?>
                    <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>
                </div><!-- /.col -->

                <div class="col-md-3 sidebar">
                    <?php get_sidebar(); ?>
                </div><!-- /.sidebar -->

            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
<?php get_footer();