<?php
/**
 * Подключение модуцля шашли дешевле
 */
function cr_decks_tab_options_tab() { ?>
    <li class="cr_modules"><a href="#cr_deck"><?php _e('Вкладки', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_decks_tab_options_tab');

/**
 * Контент блока нашли девле
 */
function cr_decks_tab_options() {
    global $post;
    $deck_tab_text  = get_post_meta( $post->ID, '_deck_tab_text', true );
    $deck_tab_text_tov = get_post_meta( $post->ID, '_deck_tab_text_tov', true );
    $ins_text = get_post_meta( $post->ID, '_ins_text', true );
    $sert_text = get_post_meta( $post->ID, '_sert_text', true );
    ?>
    <div id="cr_deck" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">

            <fieldset class="form-field">
                <div class="wrap">

                    <p>
                        <label>Текст справа от сравнения, если поле пустое будет выведен текст - Вы можете купить <?php echo get_the_title($post->ID); ?> в магазинах по доступной цене. <?php echo get_the_title($post->ID); ?>: описание, фото, характеристики, отзывы покупателей, инструкция и аксессуары. </label>
                        <textarea class="short" row="2" cols="20"  name="_deck_tab_text" id="_deck_tab_text"><?php echo $deck_tab_text; ?></textarea>
                    </p>

                    <p>
                        <label>Текст Как получить товар? </label>
                        <textarea class="short" row="2" cols="20"  name="_deck_tab_text_tov" id="_deck_tab_text_tov"><?php echo $deck_tab_text_tov; ?></textarea>
                    </p>

                    <p>
                        <label>Ссылка на инструкцию </label>
                        <textarea class="short" row="2" cols="20"  name="_ins_text" id="_ins_text"><?php echo $ins_text; ?></textarea>
                    </p>

                    <p>
                        <label>Cсылка на сртефикат соответствия </label>
                        <textarea class="short" row="2" cols="20"  name="_sert_text" id="_sert_text"><?php echo $sert_text; ?></textarea>
                    </p>
                </div>
            </fieldset>
        </div>
    </div>
    <?php
}
add_action('woocommerce_product_write_panels', 'cr_decks_tab_options');