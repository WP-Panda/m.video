<?php
/**
 * Магазины
 */
function cr_woocommerce_shops_tabs() {
    wc_get_template( 'single-product/panda-block/shops.php' );
}

/**
 * Подключение вкладки магазины
 */
function cr_shops_tab_options_tab() { ?>
    <li class="cr_modules"><a href="#cr_shops"><?php _e('Магазины', 'woothemes'); ?></a></li>
    <?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_shops_tab_options_tab');

/**
 * Контент блока магазины
 */
function cr_shops_tab_options() {
    global $post;
    $prise = get_post_meta( $post->ID, '_bonus_price', true );
    $title  = get_post_meta( $post->ID, '_bonus_title', true );
    $text  = get_post_meta( $post->ID, '_bonus_text', true );
    $color = get_post_meta( $post->ID, '_bonus_color', true );
    $block_bonus_border = get_post_meta( $post->ID, '_block_bonus_border', true );
    ?>
    <div id="cr_shops" class="panel woocommerce_options_panel">
        <style>
            #cr_shops .woocommerce_options_panel legend{
                margin: 0;
            }
        </style>
        <div class="club-opening-hours">

            <fieldset class="form-field">

                <div class="wrap">

                    <h3>г. Минск </h3>
                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_nal_1',
                            'label'       => __( 'Наличие', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_nal_1', true ),
                            'options' => array(
                                'one'   => __( 'Мало', 'woocommerce' ),
                                'two'   => __( 'Средне', 'woocommerce' ),
                                'three' => __( 'Много', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_zab_1',
                            'label'       => __( 'Забрать', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_zab_1', true ),
                            'options' => array(
                                'one'   => __( 'Сегодня', 'woocommerce' ),
                                'two'   => __( 'Завтра', 'woocommerce' ),
                                'three' => __( 'В течении недели', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <h3>г.Могилев  </h3>
                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_nal_2',
                            'label'       => __( 'Наличие', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_nal_2', true ),
                            'options' => array(
                                'one'   => __( 'Мало', 'woocommerce' ),
                                'two'   => __( 'Средне', 'woocommerce' ),
                                'three' => __( 'Много', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_zab_2',
                            'label'       => __( 'Забрать', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_zab_2', true ),
                            'options' => array(
                                'one'   => __( 'Сегодня', 'woocommerce' ),
                                'two'   => __( 'Завтра', 'woocommerce' ),
                                'three' => __( 'В течении недели', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <h3>г.Витебск </h3>
                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_nal_3',
                            'label'       => __( 'Наличие', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_nal_3', true ),
                            'options' => array(
                                'one'   => __( 'Мало', 'woocommerce' ),
                                'two'   => __( 'Средне', 'woocommerce' ),
                                'three' => __( 'Много', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_zab_3',
                            'label'       => __( 'Забрать', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_zab_3', true ),
                            'options' => array(
                                'one'   => __( 'Сегодня', 'woocommerce' ),
                                'two'   => __( 'Завтра', 'woocommerce' ),
                                'three' => __( 'В течении недели', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <h3>г. Гродно </h3>
                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_nal_4',
                            'label'       => __( 'Наличие', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_nal_4', true ),
                            'options' => array(
                                'one'   => __( 'Мало', 'woocommerce' ),
                                'two'   => __( 'Средне', 'woocommerce' ),
                                'three' => __( 'Много', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_zab_4',
                            'label'       => __( 'Забрать', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_zab_4', true ),
                            'options' => array(
                                'one'   => __( 'Сегодня', 'woocommerce' ),
                                'two'   => __( 'Завтра', 'woocommerce' ),
                                'three' => __( 'В течении недели', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <h3>г. Брест </h3>
                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_nal_5',
                            'label'       => __( 'Наличие', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_nal_5', true ),
                            'options' => array(
                                'one'   => __( 'Мало', 'woocommerce' ),
                                'two'   => __( 'Средне', 'woocommerce' ),
                                'three' => __( 'Много', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_zab_5',
                            'label'       => __( 'Забрать', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_zab_5', true ),
                            'options' => array(
                                'one'   => __( 'Сегодня', 'woocommerce' ),
                                'two'   => __( 'Завтра', 'woocommerce' ),
                                'three' => __( 'В течении недели', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <h3>г. Гомель </h3>
                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_nal_6',
                            'label'       => __( 'Наличие', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_nal_6', true ),
                            'options' => array(
                                'one'   => __( 'Мало', 'woocommerce' ),
                                'two'   => __( 'Средне', 'woocommerce' ),
                                'three' => __( 'Много', 'woocommerce' )
                            )
                        )
                    ) ?>

                    <?php woocommerce_wp_radio(
                        array(
                            'id'          => '_shop_zab_6',
                            'label'       => __( 'Забрать', 'woocommerce' ),
                            'description' => __( 'Выберите значение.', 'woocommerce' ),
                            'value'       =>  get_post_meta( $post->ID, '_shop_zab_6', true ),
                            'options' => array(
                                'one'   => __( 'Сегодня', 'woocommerce' ),
                                'two'   => __( 'Завтра', 'woocommerce' ),
                                'three' => __( 'В течении недели', 'woocommerce' )
                            )
                        )
                    ) ?>



                </div>
            </fieldset>
        </div>
    </div>
    <?php
}
add_action('woocommerce_product_write_panels', 'cr_shops_tab_options');