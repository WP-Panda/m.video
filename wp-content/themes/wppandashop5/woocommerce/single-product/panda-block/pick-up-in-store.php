<?php
global $post;
$pick_text  = get_post_meta( $post->ID, '_pick_text', true );
$pick_text  = ! empty( $pick_text ) ? $pick_text : 'Бесплатно,	Премия';
$pick_summ  = get_post_meta( $post->ID, '_pick_summ', true );
$pick_summ  = ! empty( $pick_summ ) ? $pick_summ : '500';
$pick_link  = get_post_meta( $post->ID, '_pick_link', true );
$pick_link  = ! empty ( $pick_link ) ? $pick_link : '#';
?>

<div class="div">
    <a href="<?php echo $pick_link; ?>">Забрать в магазине</a>
    <p><?php echo $pick_text; ?> <span><?php echo $pick_summ; ?></span></p>
    <i class="fa fa-shopping-cart"></i>
</div>

