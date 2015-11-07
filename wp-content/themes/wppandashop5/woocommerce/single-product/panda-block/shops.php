<?php
/**
 * Created by PhpStorm.
 * User: Максим
 * Date: 07.11.2015
 * Time: 3:13
 */

function indicator($f){
    if( $f == 'one' ) {
        $out = '<i class="fa fa-pause"></i>';
    } elseif ($f == 'two'){
        $out = '<i class="fa fa-pause"></i><i class="fa fa-pause"></i>';
    } else {
        $out = '<i class="fa fa-pause"></i><i class="fa fa-pause"></i><i class="fa fa-pause"></i>';
    }

    return $out;
}

function indicator_timer($f){
    if( $f == 'one' ) {
        $out = 'Сегодня';
    } elseif ($f == 'two'){
        $out = 'Завтра';
    } else {
        $out = 'В течении недели';
    }

    return $out;
}

global $post;

$z1 =   get_post_meta( $post->ID, '_shop_zab_1', true );
$z1 = ! empty( $z1 ) ? $z1 : 'one';
$n1 =   get_post_meta( $post->ID, '_shop_nal_1', true );
$n1 = ! empty( $n1 ) ? $n1 : 'one';

$z2 =   get_post_meta( $post->ID, '_shop_zab_2', true );
$z2 = ! empty( $z2 ) ? $z2 : 'one';
$n2 =   get_post_meta( $post->ID, '_shop_nal_2', true );
$n2 = ! empty( $n2 ) ? $n2 : 'one';

$z3 =   get_post_meta( $post->ID, '_shop_zab_3', true );
$z3 = ! empty( $z3 ) ? $z3 : 'one';
$n3 =   get_post_meta( $post->ID, '_shop_nal_3', true );
$n3 = ! empty( $n3 ) ? $n3 : 'one';

$z4 =   get_post_meta( $post->ID, '_shop_zab_4', true );
$z4 = ! empty( $z4 ) ? $z4 : 'one';
$n4 =   get_post_meta( $post->ID, '_shop_nal_4', true );
$n4 = ! empty( $n4 ) ? $n4 : 'one';

$z5 =   get_post_meta( $post->ID, '_shop_zab_5', true );
$z5 = ! empty( $z5 ) ? $z5 : 'one';
$n5 =   get_post_meta( $post->ID, '_shop_nal_5', true );
$n5 = ! empty( $n5 ) ? $n5 : 'one';

$z6 =   get_post_meta( $post->ID, '_shop_zab_6', true );
$z6 = ! empty( $z5 ) ? $z6 : 'one';
$n6 =   get_post_meta( $post->ID, '_shop_nal_6', true );
$n6 = ! empty( $n5 ) ? $n6 : 'one';
?>

<div class="cr-product-block">

    <div class="outer-xs">
        <div class="col-xs-3 lh-1-6">
            <b>г. Минск</b><br>
            ТЦ "ГРАД" павильон №77<br>
            ул.Тимирязева 123\2<br>
            <i class="fa fa-mobile"></i> +375 29 666 05 81 (Velcom)<br>
            <i class="fa fa-mobile"></i> +375 33 666 05 81 (MTC)<br>
            <i class="fa fa-phone"></i> +375 17 396 60 54<br>
            <i class="fa fa-envelope-o"></i> grad@bydom.by
        </div>
        <div class="col-xs-2"><?php echo indicator($z1); ?></div>
        <div class="col-xs-2"><?php echo indicator_timer($n1); ?></div>
        <div class="col-xs-2 lh-1-6 text-center">Вторник - Воскресенье<br> с <b>10.00</b> до <b>17.00</b></div>
        <div class="col-xs-3">Можно получить только после онлайн-оплаты</div>
    </div>
    <div class="clearfix border outer-top-x"></div>

    <div class="outer-xs">
        <div class="col-xs-3 lh-1-6">
            <b>г.Могилев</b><br>
            ТЦ "Строймаркет" пав.№76<br>
            ул.Чайковского, 8<br>
            <i class="fa fa-mobile"></i> +375 29 378 43 23 (Velcom)<br>
            <i class="fa fa-mobile"></i> +375 33 378 43 23 (МТС)<br>
            <i class="fa fa-envelope-o"></i> mogilev@bydom.by
        </div>
        <div class="col-xs-2"><?php echo indicator($z2); ?></div>
        <div class="col-xs-2"><?php echo indicator_timer($n2); ?></div>
        <div class="col-xs-2 lh-1-6 text-center">Ежедневно<br> с <b>10.00</b> до <b>19.00</b></div>
        <div class="col-xs-3">Можно получить только после онлайн-оплаты</div>
    </div>
    <div class="clearfix border outer-top-x"></div>

    <div class="outer-xs">
        <div class="col-xs-3 lh-1-6">
            <b>г.Витебск</b><br>
            ТЦ "ОМЕГА"<br>
            пр-т Строителей 11-А<br>
            <i class="fa fa-mobile"></i> +375 44 725 48 46 (Velcom)<br>
            <i class="fa fa-mobile"></i> +375 29 235 48 46 (МТС)<br>
            <i class="fa fa-envelope-o"></i> vitebsk@bydom.by
        </div>
        <div class="col-xs-2"><?php echo indicator($z3); ?></div>
        <div class="col-xs-2"><?php echo indicator_timer($n3); ?></div>
        <div class="col-xs-2 lh-1-6 text-center">Ежедневно<br> с <b>10.00</b> до <b>19.00</b></div>
        <div class="col-xs-3">Можно получить только после онлайн-оплаты</div>
    </div>
    <div class="clearfix border outer-top-x"></div>

    <div class="outer-xs">
        <div class="col-xs-3 lh-1-6">
            <b>г. Гродно</b><br>
            Южный вещевой рынок<br>
            Индурское шоссе, д30<br>
            <i class="fa fa-mobile"></i> +375 29 239 22 22 (МТС)<br>
            <i class="fa fa-envelope-o"></i> grodno@bydom.by
        </div>
        <div class="col-xs-2"><?php echo indicator($z4); ?></div>
        <div class="col-xs-2"><?php echo indicator_timer($n4); ?></div>
        <div class="col-xs-2 lh-1-6 text-center">Вторник - Воскресенье<br> с <b>10.00</b> до <b>17.00</b></div>
        <div class="col-xs-3">Можно получить только после онлайн-оплаты</div>
    </div>
    <div class="clearfix border outer-top-x"></div>

    <div class="outer-xs">
        <div class="col-xs-3 lh-1-6">
            <b>г. Брест</b><br>
            Онлайн дом<br>
            ул. Карьерная, 12<br>
            <i class="fa fa-mobile"></i> +375 33 691 22 22 (МТС)<br>
            <i class="fa fa-envelope-o"></i> brest@bydom.by
        </div>
        <div class="col-xs-2"><?php echo indicator($z5); ?></div>
        <div class="col-xs-2"><?php echo indicator_timer($n5); ?></div>
        <div class="col-xs-2 lh-1-6 text-center">Вторник - Воскресенье<br> с <b>10.00</b> до <b>17.00</b></div>
        <div class="col-xs-3">Можно получить только после онлайн-оплаты</div>
    </div>
    <div class="clearfix border outer-top-xs"></div>

    <div class="outer-xs">
        <div class="col-xs-3 lh-1-6">
            <b>г. Гомель</b><br>
            ТЦ Секрет<br>
            ул. Гагарина, 65<br>
            <i class="fa fa-mobile"></i> +375 33 691 22 22 (МТС)<br>
            <i class="fa fa-envelope-o"></i> gomel@bydom.by
        </div>
        <div class="col-xs-2"><?php echo indicator($z6); ?></div>
        <div class="col-xs-2"><?php echo indicator_timer($n6); ?></div>
        <div class="col-xs-2 lh-1-6 text-center">Вторник - Воскресенье<br> с <b>10.00</b> до <b>17.00</b></div>
        <div class="col-xs-3">Можно получить только после онлайн-оплаты</div>
    </div>

</div>
