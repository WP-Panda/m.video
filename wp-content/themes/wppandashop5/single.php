<?php
get_header(); ?>

<?php get_template_part('templates/components/header/breadcrumb'); ?>

    <div class="body-content">
        <div class="container">
            <div class="row blog">

                <div class="col-md-12">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part('templates/content-templates/blog/blog','single-post'); ?>

                        <?php comments_template(); ?>

                    <?php endwhile; else: ?>
                        <p><?php _e('Sorry, no posts matched your criteria.','wppandashop5'); ?></p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
<?php get_footer();