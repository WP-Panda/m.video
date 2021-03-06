<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 14.10.2015
 * Time: 1:56
 */
global $wps5_option;

/**
 * Константы
 */
define('WPS5_BASE_DIR',trailingslashit( get_template_directory_uri() ) );
define('WPS5_BASE_URI',trailingslashit( get_template_directory() ) );

/**
 * Активация всякого в тему
 */
function wps5_theme_setup() {

    /* Активация тайтла */
    add_theme_support('title-tag');
    /* Support for HTML5 */
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery'));
    /* Automatic Feed Links */
    add_theme_support('automatic-feed-links');
    /* Add thumbnails support */
    add_theme_support('post-thumbnails');
    /* woocommerce */
    add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'wps5_theme_setup' );

/**
 * Подключение скриптов и стилей
 */
function wps5_register_scripts() {

    wp_enqueue_style( 'bootstrap-css', WPS5_BASE_DIR . 'assets/css/bootstrap.min.css', false, '1.0.0' );
    wp_enqueue_style( 'font-awesome-css', WPS5_BASE_DIR . 'assets/css/font-awesome.min.css', false, '1.0.0' );
    wp_enqueue_style( 'yamm-css', WPS5_BASE_DIR . 'assets/css/yamm.css', false, '3.0.0' );
    wp_enqueue_style( 'lightbox-css', WPS5_BASE_DIR . 'assets/css/lightbox.css', false, time() );
    wp_enqueue_style( 'animate-css', WPS5_BASE_DIR . 'assets/css/animate.min.css', false, time() );
    wp_enqueue_style( 'main-css', WPS5_BASE_DIR . 'assets/css/main.css', false, '1.0.0' );
    wp_enqueue_style( 'Raleway-css', 'http://fonts.googleapis.com/css?family=Raleway:100,200,400,300,500,600,800,700,900', false, time() );
    wp_enqueue_style( 'Montserrat-css', 'http://fonts.googleapis.com/css?family=Montserrat:400,700', false, time() );
    wp_enqueue_style( 'Lato-css', 'http://fonts.googleapis.com/css?family=Lato:400,900', false, time() );

    wp_enqueue_script( 'bootstrap-js', WPS5_BASE_DIR . 'assets/js/bootstrap.min.js', array( 'jquery' ), '3.3.1', true );
    wp_enqueue_script( 'bootstrap-slider-js', WPS5_BASE_DIR . 'assets/js/bootstrap-slider.min.js', array(), '4.0.5', true );
    wp_enqueue_script( 'owl-js', WPS5_BASE_DIR . 'assets/js/owl.carousel.min.js', array(), time(), true );
    wp_enqueue_script( 'bootstrap-hover-dropdown-js', WPS5_BASE_DIR . 'assets/js/bootstrap-hover-dropdown.min.js', array(), '2.1.3', true );
    wp_enqueue_script( 'custom-select-js', WPS5_BASE_DIR . 'assets/js/jquery.custom-select.js', array(), '0.5.1', true );
    wp_enqueue_script( 'pace-js', WPS5_BASE_DIR . 'assets/js/pace.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'easing-js', WPS5_BASE_DIR . 'assets/js/jquery.easing-1.3.min.js', array( ), '1.3', true );
    wp_enqueue_script( 'wow-js', WPS5_BASE_DIR . 'assets/js/wow.min.js', array(), '1.0.3', true );
    wp_enqueue_script( 'echo-js', WPS5_BASE_DIR . 'assets/js/echo.min.js', array(), '1.6.0', true );
    wp_enqueue_script( 'light', WPS5_BASE_DIR . 'assets/js/lightbox.min.js', array(), '2.0.0', true );
    wp_enqueue_script( 'main-js', WPS5_BASE_DIR . 'assets/js/scripts.js', array( ), '1.0.0', true );

}
add_action( 'wp_enqueue_scripts', 'wps5_register_scripts' );

$e = 'mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm mmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm mmmmmmmmmmmm mmmmmmmmmmmmm mmmmmmmmmmmmmmmmmmmmmmmmmmm mmm mmmm mmm mm m m mmmmmmmm mmmmm mmmm mmmmm';
/**
 * Сайдбары
 */
$args = array(
    'name'          => 'Сайдбар %d',
    'id'            => "sidebar",
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget'  => '</li>',
    'before_title'  => '<h2 class="widgettitle">',
    'after_title'   => '</h2>'
);
register_sidebars( 2, $args );


/**
 * Сайдбар футера
 */

function register_cr_widgets(){
    register_sidebar( array(
        'name' => sprintf(__('Футер %d'), 1 ),
        'id' => "footer-1",
        'description' => '',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>\n",
        'before_title' => '<div class="foot-title"><h4 class="title">',
        'after_title' => "</h4></div>\n",
    ) );

    register_sidebar( array(
        'name' => sprintf(__('Футер %d'), 2 ),
        'id' => "footer-2",
        'description' => '',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>\n",
        'before_title' => '<div class="foot-title"><h4 class="title">',
        'after_title' => "</h4></div>\n",
    ) );

    register_sidebar( array(
        'name' => sprintf(__('Футер %d'), 3 ),
        'id' => "footer-3",
        'description' => '',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>\n",
        'before_title' => '<div class="foot-title"><h4 class="title">',
        'after_title' => "</h4></div>\n",
    ) );

    register_sidebar( array(
        'name' => sprintf(__('Футер %d'), 4 ),
        'id' => "footer-4",
        'description' => '',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>\n",
        'before_title' => '<div class="foot-title"><h4 class="title">',
        'after_title' => "</h4></div>\n",
    ) );

    register_sidebar( array(
        'name' => sprintf(__('Футер %d'), 5 ),
        'id' => "footer-5",
        'description' => '',
        'class' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => "</div>\n",
        'before_title' => '<div class="foot-title"><h4 class="title">',
        'after_title' => "</h4></div>\n",
    ) );
}
add_action( 'widgets_init', 'register_cr_widgets' );



/**
 * Подключение всякого
 */
//компоненты redux
require_once(WPS5_BASE_URI .'/framework/redux/redux-core/framework.php');
require_once(WPS5_BASE_URI .'/framework/redux/loader.php');
require_once(WPS5_BASE_URI .'/framework/redux/meta-config.php');
require_once(WPS5_BASE_URI .'/framework/redux/config.php');
//обрезка миниатюр
require_once(WPS5_BASE_URI .'/framework/bfi-thumb.php');
//хлебные крошки
require_once(WPS5_BASE_URI .'/framework/breadcrumbs.php');
//настройки woocommerce
require_once(WPS5_BASE_URI .'/framework/woocommerce-config.php');
//кнопка wishlist
//require_once(WPS5_BASE_URI .'/framework/wishlist/wishlist.php');
//кнопка compare
//require_once(WPS5_BASE_URI .'/framework/compare/compare.php');

//метабоксы таксономий
require_once(WPS5_BASE_URI .'/framework/tax-meta.php');

//функции кирилицы
if( ! empty( $wps5_option['cyrillic_site'] ) && 'on' == $wps5_option['cyrillic_site'] )
    require_once(WPS5_BASE_URI .'/framework/cir-to-lat.php');


/**
 * Активация меню
 */
add_action('after_setup_theme', function(){
    register_nav_menus( array(
        'header_menu' => 'Меню в шапке',
        'footer_menu' => 'Меню в подвале'
    ) );
});

/**
 * Получение размера файла
 */
function getSize($file){
    $bytes = filesize($file);
    $s = array('b', 'Kb', 'Mb', 'Gb');
    $e = floor(log($bytes)/log(1024));
    return sprintf('%.2f '.$s[$e], ($bytes/pow(1024, floor($e))));
}