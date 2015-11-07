<?php
/**
* Вкладка модули
*/

function cr_modules_tab_options_tab() { ?>
<li class="cr_modules"><a href="#cr_modules_tab"><?php _e('Модули', 'woothemes'); ?></a></li>
<?php
}
add_action('woocommerce_product_write_panel_tabs', 'cr_modules_tab_options_tab');

/**
 * Custom Tab Options
 *
 * Provides the input fields and add/remove buttons for custom tabs on the single product page.
 */
function cr_modules_tab_options() {
    global $post;

    $opening_hours_options = array(
        'title' => get_post_meta($post->ID, 'opening_hours_title', true),
        'content' => get_post_meta($post->ID, 'opening_hours_content', true),
    );
    ?>
    <div id="cr_modules_tab" class="panel woocommerce_options_panel">
        <div class="club-opening-hours">
            <p class="form-field day_field_type">
            </p>


            <style>
                #sortable1, #sortable2 {
                    border: 1px solid #eee;
                    width: 40%;
                    min-height: 20px;
                    list-style-type: none;
                    margin: 0;
                    padding: 5px 0 0 0;
                    float: left;
                    margin-right: 10px;
                }
                #sortable1 li, #sortable2 li {
                    margin: 0 5px 5px 5px;
                    padding: 5px;
                    font-size: 1.2em;
                    /* width: 120px; */
                }

                .woocommerce_options_panel label, .woocommerce_options_panel legend {
                   margin: 0!important;
                }

                .woocommerce_options_panel fieldset.form-field, .woocommerce_options_panel p.form-field{
                    padding: 0!important;
                }

                #cr_woocommerce_query_sales,
                #cr_woocommerce_price,
                #cr_woocommerce_bonus,
                #cr_woocommerce_add_cart,
                #cr_woocommerce_favorites,
                #cr_woocommerce_pick_up_in_store,
                #cr_woocommerce_shipping_in_home,
                #cr_woocommerce_discount,
                #cr_woocommerce_compare
                {
                    background-color: #a9a4cc;
                    background-image: none;
                }

            </style>
            <script>
                jQuery(function($) {
                    $(function () {

                        $("#sortable1, #sortable2").sortable({
                            connectWith: ".connectedSortable",
                            update: function( event, ui ) {
                                $array = {};
                                $('#sortable2 li').each(function(){
                                    $array[$(this).html()] = $(this).data('block');
                                });

                                console.log($array);
                                console.log($array.toString());
                                $('#cr_single_modules').val(JSON.stringify($array));
                            }
                        }).disableSelection();



                    });
                });
            </script>

            <?php $array_block=array(
                'Заголовок'         => 'woocommerce_template_single_title',
                'Рейтинг'           => 'woocommerce_template_single_rating',
                'Стоимость'         => 'woocommerce_template_single_price',
                'Описание'          => 'woocommerce_template_single_excerpt',
                'Добавить в корзину'=> 'woocommerce_template_single_add_to_cart',
                'Мета'              => 'woocommerce_template_single_meta',
                'Поделиться'        => 'woocommerce_template_single_sharing',
                'Нашли дешевле?'    => 'cr_woocommerce_query_sales',
                'Цена'              => 'cr_woocommerce_price',
                'Бонус'             => 'cr_woocommerce_bonus',
                'В корзину'         => 'cr_woocommerce_add_cart',
                'В избранное'       => 'cr_woocommerce_favorites',
                'Забрать в магазине'=> 'cr_woocommerce_pick_up_in_store',
                'Доставка на дом'   => 'cr_woocommerce_shipping_in_home',
                'Скидки'            => 'cr_woocommerce_discount',
                'Сравнение'         => 'cr_woocommerce_compare'
            ); ?>
            <?php $content = get_post_meta($post->ID, '_cr_single_modules_card', true);

            //if( in_array( 'woocommerce_template_single_sharing',$content_to_field ) ) { ?>
            <fieldset class="form-field">
                <label for="day_field_type"><?php echo __( 'Настройка модулей', 'woocommerce' ); ?></label>
                <div class="wrap">

                    <span> Неактивные </span>
                    <ul id="sortable1" class="connectedSortable">
                        <?php
                        $content_to_field = (array)json_decode($content);
                        foreach ( $array_block as $key =>$val ) {

                          /*  if($val === 'cr_woocommerce_query_sales') {
                                $edit = '<a href="#cr_sales_tab">Настроить</a>';
                            } elseif($val === 'cr_woocommerce_price'){
                                $edit = '<a href="#cr_price_tab">Настроить</a>';
                            } else {
                                $edit ='';
                            }*/


                            if( ! in_array( $val,$content_to_field ) ) {
                                echo '<li class="ui-state-default"  id="' . $val . '"  data-block="' . $val . '">' . $key  . '</li>';
                            }
                        }
                        ?>

                    </ul>

                    <span> Активные </span>
                    <ul id="sortable2" class="connectedSortable">
                        <?php foreach ( $content_to_field  as $key =>$val ) {
                          /*  if($val === 'cr_woocommerce_query_sales'){
                                $edit = '<a href="#cr_sales_tab">Настроить</a>';
                            } else {
                                $edit ='';
                            }*/
                            echo '<li class="ui-state-default"  id="' . $val . '" data-block="' . $val . '">' . $key  . '</li>';
                            //}
                        } ?>
                    </ul>

                    <input type="hidden" name="_cr_single_modules_card" value="<?php echo htmlspecialchars($content); ?>" id="cr_single_modules" />
                </div>
            </fieldset>
        </div>
    </div>
    <?php ;
}
add_action('woocommerce_product_write_panels', 'cr_modules_tab_options');

function woo_cr_colorist() { ?>

<!--    <script>-->
<!--        (function( $ ) {-->
<!--            // Add Color Picker to all inputs that have 'color-field' class-->
<!--            $(function() {-->
<!--                $('.color-field').wpColorPicker();-->
<!--            });-->
<!--        })( jQuery );-->
<!--    </script>-->

<?php }

add_action('admin_footer','woo_cr_colorist',1000);