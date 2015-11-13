<?php
$term = get_queried_object();
$term_id = $term->term_id;
$children = get_term_children( $term_id, 'product_cat' );
if(  $children ) : ?>

    <div class="sidebar-widget sidebar-filter sidebar-categories-wrapper">
        <div class="sidebar-title">
            <h3><?php echo $term->name; ?></h3>
        </div>
        <ul class="unstyled sidebar-categories-list">
            <?php
            $args = array(
                'parent' => $term_id,
            );

            $myterms = get_terms( array( 'product_cat' ), $args );

            foreach( $myterms as $term ){ ?>
                <li class="sidebar-category"><a href="<?php echo get_term_link((int)$term->term_id, 'product_cat'); ?>" title="<?php echo $term->name; ?>"><?php echo $term->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>

    <?php
else :
    if ( function_exists('dynamic_sidebar') )
        dynamic_sidebar('sidebar');
endif;
?>