<?php
global $post;

$deck_tab_text  = get_post_meta( $post->ID, '_deck_tab_text', true );
$deck_tab_text = (! empty($deck_tab_text)) ? $deck_tab_text : 'Вы можете купить ' . get_the_title($post->ID) . ' в магазинах по доступной цене. ' . get_the_title($post->ID) . ': описание, фото, характеристики, отзывы покупателей, инструкция и аксессуары.';
$terms = wp_get_post_terms( $post->ID, 'product_cat');

?>
<div class="cr-product-block">

    <div class="block-title-block">
        <h3 class="block-title col-xs-10 inner-tabber">Описание</h3>
        <a class="col-xs-2 inner-tabber" href="#tab-spec">Посмотреть все <i class="fa fa-angle-right"></i></a>
    </div>
    <div class="clearfix"></div>

    <div class="col-xs-12 taber-cont">
        <?php the_content(); ?>
    </div>


    <div class="col-xs-8">
        <?php $cont = new BE_Compare_Products();
        $cont->new_product_tab_content_short();
        ?>
    </div>
    <div class="col-xs-4">
        <h3 class="deck-title"><?php the_title(); ?></h3>
        <p>
            <?php echo $deck_tab_text; ?>
        </p>
        <a href="<?php echo get_term_link((int)$terms[0]->term_id,'product_cat'); ?> ">Смотреть все <?php echo $terms[0]->name ?></a>
    </div>
    <div class="col-xs-12 text-center all-cpec">
        <a href="#tab-spec" class="inner-tabber">Смотреть все Спецификации</a>
    </div>
</div>