<?php
global $post;
$text = get_post_meta( $post->ID, '_compare_text', true );
$text = !empty($text) ? $text : 'В избранное';
$block_favorites_border = get_post_meta( $post->ID, '_block_compare_border', true );
$block_favorites_border = 1 == $block_favorites_border ? ' none-border' : '';

?>
<div class="cr-product-block cr-compare-block<?php echo $block_favorites_border; ?>">
    <?php $class = new BE_Compare_Products();
    $class->display_button();   ?>
</div>

