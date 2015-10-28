<?php
/**
 * Блок нашли дешевле?
 */
function cr_woocommerce_bonus() {
    wc_get_template( 'single-product/panda-block/bonus.php' );
}

/**
 * Подключение модуцля шашли дешевле
 */
function cr_bonus_tab_options_tab() { ?>
    <li class="cr_modules"><a href="#cr_bonus"><?php _e('Бонус', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_bonus_tab_options_tab');

/**
 * Контент блока нашли девле
 */
function cr_bonus_tab_options() {
    global $post;
    $prise = get_post_meta( $post->ID, '_bonus_price', true );
    $title  = get_post_meta( $post->ID, '_bonus_title', true );
    $text  = get_post_meta( $post->ID, '_bonus_text', true );
    $color = get_post_meta( $post->ID, '_bonus_color', true );
    $block_bonus_border = get_post_meta( $post->ID, '_block_bonus_border', true );
    ?>
    <div id="cr_bonus" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">

            <fieldset class="form-field">
                <div class="wrap">

                    <p>
                        <label>Цвет фона цифр модуля: </label>
                        <input class="color-field" type="text" name="_bonus_color" value="<?php echo $color; ?>"/>
                    </p>
                    <p>
                        <label>Текст заголовка модуля: </label>
                        <input type="text" class="short"  name="_bonus_title" id="_bonus_title" value="<?php echo $title; ?>"/>
                    </p>
                    <p>
                        <label>Текст модуля: </label>
                        <textarea class="short" row="2" cols="20"  name="_bonus_text" id="_bonus_text"><?php echo $text; ?></textarea>
                    </p>
                    <p>
                        <label>Cумма скидки модуля (по умолчаниб 3%): </label>
                        <input type="text" class="short"  name="_bonus_price" id="_bonus_price" value="<?php echo $prise; ?>"/>
                    </p>

                    <p>
                        <label for="_block_bonus_border">Не включать разделитель: </label>
                        <input type="checkbox" name="_block_bonus_border" id="_block_bonus_border" value="1" <?php checked( $block_bonus_border ); ?>/>
                    </p>

                </div>
            </fieldset>
        </div>
    </div>
    <script>
        (function( $ ) {
            // Add Color Picker to all inputs that have 'color-field' class
            $(function() {
                $('.color-field').wpColorPicker();
            });
        })( jQuery );
    </script>
    <?php ;
}
add_action('woocommerce_product_write_panels', 'cr_bonus_tab_options');