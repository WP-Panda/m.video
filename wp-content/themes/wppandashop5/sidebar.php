<?php
$term = get_queried_object();
$term_id = $term->term_id;
$children = get_term_children( $term_id, 'product_cat' );
if(  $children ) : ?>

    <div class="sidebar-widget sidebar-filter">
        <h3 class="section-title"><?php echo $term->name; ?></h3>
        <ul>
            <?php
            $args = array(
                'parent' => $term_id,
            );

            $myterms = get_terms( array( 'product_cat' ), $args );

            foreach( $myterms as $term ){ ?>
                <li><a href="<?php echo get_term_link((int)$term->term_id, 'product_cat'); ?>" title="<?php echo $term->name; ?>"><?php echo $term->name; ?>(<?php echo $term->count; ?>)</a></li>
            <?php } ?>
        </ul>
    </div>

    <?php
else :
    if ( function_exists('dynamic_sidebar') )
        dynamic_sidebar('sidebar');
endif;
?>