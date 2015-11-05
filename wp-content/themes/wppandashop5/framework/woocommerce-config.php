<?php


/**
 * Подключение плагинов
 */
require_once 'plugins/init-plugins.php';

/**
 * Query WooCommerce activation
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        return class_exists( 'woocommerce' ) ? true : false;
    }
}

require_once 'cr_woo_short.php';

/**
 * Категория продукта по ID
 */
function get_product_category_by_product_id( $id ) {
    $term = wp_get_post_terms( $id, 'product_cat' );
    return $term;
}


/**
 * Отключение подобных продуктов
 */
remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_related_products',20 );
/**
 * Отключение сайдбара на транице продукты
 */
remove_action( 'woocommerce_sidebar','woocommerce_get_sidebar',10 );
/**
 * отключение распродажи
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
/**
 * отключение миниатюры
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
/**
 * Отключение хлебных крошек WooCoommerce
 */
add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    add_action('woocommerce_before_main_content','bootstrap_breadcrumb',20);
}


// Отключение стилей по одному
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
   // unset( $enqueue_styles['woocommerce-general'] );	// Отключение общий стилей
    unset( $enqueue_styles['woocommerce-layout'] );		// Отключение стилей шаблонов
   // unset( $enqueue_styles['woocommerce-smallscreen'] );	// Отключение оптимизации для маленьких экранов
    return $enqueue_styles;
}

// // Или просто удалить их все в одной строкой
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/**
 * новая миниатюра и распродажа
 */
add_action( 'woocommerce_before_shop_loop_item_title', 'cr_template_loop_product_thumbnail', 10 );


/**
 *
 */
if ( is_archive() ) {
    add_action('woocommerce_after_shop_loop_item', 'cr_woocommerce_discount', 50);
    add_action('woocommerce_after_shop_loop_item', 'cr_woocommerce_pick_up_in_store', 60);
    add_action('woocommerce_after_shop_loop_item', 'cr_woocommerce_shipping_in_home', 70);
}


/**
 * Новая миниатюра и распродажа
 * @param string $size - размер миниатюры
 */
function cr_template_loop_product_thumbnail($size = 'shop_catalog'){
    global $post, $product;
    if ( has_post_thumbnail() ) {
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size );
        $thumb = $thumb[0];
        $full = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
        $full = $full[0];
    } elseif ( wc_placeholder_img_src() ) {
        $thumb  = wc_placeholder_img_src();
        $full = $thumb;
    }

    $out = '
    <div class="product-image">
        <a href="' . get_the_permalink($post->ID). '" data-lightbox="image-1">
            <div class="image">
                <img src="' . $thumb.'" data-echo="' . $full .'" class="img-responsive" alt="">
            </div>';

    if ( $product->is_on_sale() ) {
        $out .= apply_filters( 'woocommerce_sale_flash', '<div class="tag"><div class="tag-text sale">' . __( 'Sale!', 'woocommerce' ) . '</div></div>', $post, $product );
    }

    $out.= '<div class="hover-effect"><i class="fa fa-search"></i></div>
        </a>
    </div>';

    echo $out;

}

/**
 * Добавление в списое желаний
 */
//add_action('woocommerce_after_shop_loop_item','pwlp_product_display',20);

/**
 * Добавление в сравнение
 */
//add_action( 'woocommerce_after_shop_loop_item', 'pcp_shop_display_compare', 30);

/**
 * Модули карточки товара
 */
/**
 * woocommerce_single_product_summary hook
 *
 * @hooked woocommerce_template_single_title - 5
 * @hooked woocommerce_template_single_rating - 10
 * @hooked woocommerce_template_single_price - 10
 * @hooked woocommerce_template_single_excerpt - 20
 * @hooked woocommerce_template_single_add_to_cart - 30
 * @hooked woocommerce_template_single_meta - 40
 * @hooked woocommerce_template_single_sharing - 50
 */

/*remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary','woocommerce_template_single_excerpt', 11 );
add_action( 'woocommerce_single_product_summary','woocommerce_template_single_price', 12 );*/

if ( ! function_exists( 'cr_single_variation_add_to_cart_button' ) ) {
    /**
     * Output the add to cart button for variations.
     */
    function cr_single_variation_add_to_cart_button() {
        global $product;
        ?>
        <div class="variations_button point-of-action">
            <div class="quantity">
                <label>Qty:</label>
                <?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
            </div>
            <div class="add-to-cart">
                <button type="submit" class="single_add_to_cart_button button alt btn btn-primary"><i class="fa fa-shopping-cart"></i> <?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
            </div>
            <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>" />
            <input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>" />
            <input type="hidden" name="variation_id" class="variation_id" value="" />
        </div>
        <?php
    }

    remove_action( 'woocommerce_single_variation','woocommerce_single_variation_add_to_cart_button', 20 );
    add_action( 'woocommerce_single_variation','cr_single_variation_add_to_cart_button', 20 );
}


/**
 * Подключение модулей
 */
//основная вкладка ?
require_once 'woocommerce-modules/modules-tab.php';
// нашли дешевле ?
require_once 'woocommerce-modules/sale-query-tab.php';
// цена
require_once 'woocommerce-modules/price.php';
// бонус
require_once 'woocommerce-modules/bonus.php';
// в корзину
require_once 'woocommerce-modules/add-cart.php';
// в избранное
require_once 'woocommerce-modules/favorites.php';
// забрать в мавгазине
require_once 'woocommerce-modules/pick-up-in-store.php';
//доставка на дом
require_once 'woocommerce-modules/shipping-in-home.php';
// скидки
require_once 'woocommerce-modules/discount.php';
// с этим товаром покупают
require_once 'woocommerce-modules/buy-with-this-item.php';
// с этим товаром покупают слайдер
require_once 'woocommerce-modules/buy-with-this-item-short.php';
//отзывы
require_once 'woocommerce-modules/rev.php';
//сравнение
require_once 'woocommerce-modules/compare.php';



// Save Fields
add_action( 'woocommerce_process_product_meta', 'cr_modules_tab_fields_save' );

/**
 * Сохраняет значение поля
 * @param $var
 * @param $post_id
 */
function saver($var,$post_id) {
    $variable = !empty ( $_POST[$var] ) ? $_POST[$var] : '';
    update_post_meta( $post_id, $var, $variable );
}

// Function to save all custom field information from products
function cr_modules_tab_fields_save( $post_id ){

    //конфигурация модулей
    $content = $_POST['_cr_single_modules_card'];
    update_post_meta( $post_id, '_cr_single_modules_card', $content );

    /**
     * Блок нашли дешевле
     */
    //заголовок цвет
    $color = $_POST['_title_sale_colors'];
    update_post_meta( $post_id, '_title_sale_colors', $color );
    // заголовок текст
    $title = $_POST['_title_sale_query'];
    update_post_meta( $post_id, '_title_sale_query', $title );
    // текст
    $text = $_POST['_text_sale_query'];
    update_post_meta( $post_id, '_text_sale_query', $text );
    // правила
    $rules = $_POST['_rules_sale_query'];
    $rules = esc_url($rules);
    update_post_meta( $post_id, '_rules_sale_query', $rules );
    //бордер
    saver('_block_query_border',$post_id);

    /**
     * Блок цена
     */
    saver('_block_price_border',$post_id);

    /**
     * Блок бонус
     */
    //сумма
    saver('_bonus_price',$post_id);
    //заголовок
    saver('_bonus_title',$post_id);
    //текст
    saver('_bonus_text',$post_id);
    //цвет
    saver('_bonus_color',$post_id);
    //бордер
    saver('_block_bonus_border',$post_id);

    /**
     * Кнопка в корзину
     */
    //текст
    saver('_button_text',$post_id);
    saver('_block_cart_border',$post_id);

    /**
     * Кнопка в избранное
     */
    //текст
    saver('_favorites_text',$post_id);
    //бордер
    saver('_block_favorites_border',$post_id);

    /**
     * Забрать в магазине
     */
    //текст
    saver('_pick_text',$post_id);
    //сумма
    saver('_pick_summ',$post_id);
    //ссылка
    saver('_pick_link',$post_id);
    //бордер
    saver('_block_store_border',$post_id);

    /**
     * Привезти
     */
    //текст
    saver('_shipping_text_1',$post_id);
    //сумма
    saver('_shipping_summ_1',$post_id);
    //текст2
    saver('_shipping_text_2',$post_id);
    //сумма2
    saver('_shipping_summ_2',$post_id);
    //ссылка
    saver('_shipping_link',$post_id);
    //бордер
    saver('_block_shipping_border',$post_id);

    /**
     * Скидки
     */
    //включение ксидки
    saver('_discount_card_discount',$post_id);
    //включение кредита
    saver('_discount_online_credit',$post_id);
    //включение купонов
    saver('_discount_discount_coupons',$post_id);
    //сумма скидки
    saver('_discount_summ',$post_id);
    //ссылка скидки
    saver('_discount_link',$post_id);
    //ссылка кредита
    saver('_discount_credit',$post_id);
    //текст кредита
    saver('_discount_credit_text',$post_id);
    //количество купонов
    saver('_discount_coupons',$post_id);
    //бордер
    saver('_block_discount_border',$post_id);

    /**
     * С этим товаром покупают
     */
    saver('_buy_with_this',$post_id);
}

add_filter( 'woocommerce_add_cart_item_data', 'woo_custom_add_to_cart' );


//Вкладки
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

    unset( $tabs['description'] );      	// Удаление вкладки с описанием товара
    unset( $tabs['reviews'] ); 			// Удаление вкладки с отзывами
    unset( $tabs['additional_information'] ); // Удаление вкладки с дополнительной информацией

    $tabs['main'] = array(
        'title' 	=> __( 'Обзор', 'woocommerce' ),
        'priority' 	=> 10,
        'callback' 	=> 'main_tab_content'
    );

    $tabs['spec'] = array(
        'title' 	=> __( 'Спецификации', 'woocommerce' ),
        'priority' 	=> 20,
        'callback' 	=> 'spec_tab_content'
    );

    $tabs['rev'] = array(
        'title' 	=> __( 'Отзывы', 'woocommerce' ),
        'priority' 	=> 30,
        'callback' 	=> 'rev_tab_content'
    );

    $tabs['accessories'] = array(
        'title' 	=> __( 'Акссесуары', 'woocommerce' ),
        'priority' 	=> 40,
        'callback' 	=> 'accessories_tab_content'
    );

    return $tabs;
}

/**
 * Акссесуары
 */
function accessories_tab_content()
{
    cr_woocommerce_buy_with_this_item();
}
/**
 * отз
 */
function rev_tab_content(){
    cr_woocommerce_rev();
}

/**
 * Обзор
 */

function main_tab_content() {

    global $post,$product;

    /****************************************/
    /* Комменты *****************************/
    /****************************************/

    $args = array(
        'status' => 'approve',
        'number' => '1000',
        'post_id' => $post->ID,
    );


    $comments = get_comments($args);

    $n = 1;
    foreach($comments as $comment){
        if($n > 1) continue;
        $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

        ?>
        <div class="blog cr-product-block">
            <h3>Самый полезный отзыв</h3>
            <div class="blog-comments wow fadeInUp animated">
                <ul class="media-list">
                    <li class="media">
                        <div class="media-left">
                            <?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

                                <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
                                    <span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
                                </div>

                            <?php endif; ?>
                            <a href="#">
                                <?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '74' ), '' ); ?>
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?php $comment->comment_author; ?></h4>
                            <div class="comment-action">
                                <ul class="list-inline list-unstyled">
                                    <li><time itemprop="datePublished" datetime="<?php echo $comment->comment_date; ?>"><?php echo $comment->comment_date; ?></time></li>
                                </ul>
                            </div>
                            <p><?php echo $comment->comment_content; ?></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <?php
        $n++;
    }
    ?>



    <div class="cr-product-block">
        <h3>Описание</h3>
        <div class="col-xs-12">
            <?php the_content(); ?>
        </div>
        <div class="col-xs-8">
            <?php $cont = new BE_Compare_Products();
            $cont->new_product_tab_content_short();
            ?>
        </div>
        <div class="col-xs-4">
            <span><?php the_title(); ?></span>
            <p>
                Вы можете купить <?php the_title(); ?> в магазинах М.Видео по доступной цене. <?php the_title(); ?>: описание, фото, характеристики, отзывы покупателей, инструкция и аксессуары.
            </p>
            <a href="#">Смотреть все <?php the_title(); ?></a>
        </div>
        <div class="col-xs-12 text-center">
            <a href="#tab-spec">Смотреть все Спецификации</a>
        </div>
    </div>

    <?php wc_get_template( 'single-product/panda-block/info-list.php' ); ?>

    <div class="cr-product-block">
        <h3>Как получить товар?</h3>
        <div class="col-xs-8">
            <p>Смартфон Samsung Galaxy A3 сочетает в себе высокую функциональность и стильный дизайн.
                Благодаря мощному четырехъядерному процессору он отлично работает в режиме многозадачности.
                Улучшенный интерфейс позволяет менять темы для экрана, выбирать опции для startup и многое другое.</p>

            <p>Наслаждайтесь просмотром фильмов на 4,5-дюймовом Full HD super amoled экране!
                Любите делать автопортреты? Просто произнесите голосовую команду или махните рукой.
                Режим «широкоугольное селфи» подойдет для больших компаний. А функция авторедактирования придаст фотографии яркость.
                С опцией «GIF-анимация» можно сделать 20 снимков в непрерывном режиме и создать анимированный GIF-файл!</p>

            <p>Умный смартфон самостоятельно увеличит или уменьшит громкость звонка в зависимости
                от того, где вы находитесь, благодаря функции Adjustable Audio. Смартфон оснащен LTE-модулем.
                Купите Samsung Galaxy A3 – оцените все его великолепные возможности!</p>

        </div>
        <div class="col-xs-4">

            <div>Доставить на дом
                Завтра и позже - Бесплатно
            </div>

            <div>
                Забрать в магазине
                г. Ростов-на-Дону, ул. Красноармейская, 157
                Другие магазины
                Бесплатно
                Премия 500
                Сегодня
            </div>

        </div>
    </div>

    <?php //слайдер подобные
    cr_woocommerce_buy_with_this_item_short();
    ?>

    <div class="blog cr-product-block">
        <h3>Отзывы</h3>
        <div class="blog-comments wow fadeInUp animated">
            <?php
            $rating_count = $product->get_rating_count();
            $review_count = $product->get_review_count();
            $average      = $product->get_average_rating();

            if ( $rating_count > 0 ) : ?>

                <div class="star-rating" title="<?php printf( __( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                    <span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
                        <strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( __( 'out of %s5%s', 'woocommerce' ), '<span itemprop="bestRating">', '</span>' ); ?>
                        <?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'woocommerce' ), '<span itemprop="ratingCount" class="rating">' . $rating_count . '</span>' ); ?>
                    </span>
                    <?php if ( comments_open() ) : ?>
                        <b>(<?php echo $review_count; ?>)</b>
                    <?php endif;  ?>
                </div>
                <?php
                $array = array(1=>0,2=>0,3=>0,4=>0,5=>0);
                $index = 100/$average;
                foreach($comments as $comment){
                    $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
                    $array[(int)$rating] = (int)$array[$rating] + 1;
                } ?>

                <div class="cr-rating-lines col-xs-6">
                    <?php
                    foreach ( $array as $key => $one ) { ?>
                        <span class="col-xs-2"><?php echo $key ?> звезд</span>   <div class="cr-rating-liner col-xs-8"><span style="width: <?php echo $one*$index ?>%" class="cr-rating-line"></div><span class="col-xs-2">(<?php echo $one ?>)</span>
                    <?php } ?>

                </div>

                <div class="cr-rating-lines col-xs-6">
                    <div>
                        Оставьте свой отзыв о товаре:
                        <?php the_title() ?>
                    </div>
                    <a class="btn btn-primary">В избранное</a>
                </div>
                <div class="clear"></div>

            <?php endif; ?>
            <?php
            $n = 1;
            foreach($comments as $comment){
                if($n > 1) continue;
                $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
                ?>

                <ul class="media-list">
                    <li class="media">
                        <div class="media-left">
                            <?php if ( $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes' ) : ?>

                                <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf( __( 'Rated %d out of 5', 'woocommerce' ), $rating ) ?>">
                                    <span style="width:<?php echo ( $rating / 5 ) * 100; ?>%"><strong itemprop="ratingValue"><?php echo $rating; ?></strong> <?php _e( 'out of 5', 'woocommerce' ); ?></span>
                                </div>

                            <?php endif; ?>
                            <a href="#">
                                <?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '74' ), '' ); ?>
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><?php $comment->comment_author; ?></h4>
                            <div class="comment-action">
                                <ul class="list-inline list-unstyled">
                                    <li><time itemprop="datePublished" datetime="<?php echo $comment->comment_date; ?>"><?php echo $comment->comment_date; ?></time></li>
                                </ul>
                            </div>
                            <p><?php echo $comment->comment_content; ?></p>
                        </div>
                    </li>
                </ul>

                <?php
                $n++;
            }
            ?>
        </div>
    </div>

    <?php
}

/**
 * Спецификации
 */

function spec_tab_content(){ ?>
    <div class="col-xs-4">gg</div>
    <div class="col-xs-8">
        <?php
        $cont = new BE_Compare_Products();
        $cont->new_product_tab_content();
        ?>
    </div>
<?php }