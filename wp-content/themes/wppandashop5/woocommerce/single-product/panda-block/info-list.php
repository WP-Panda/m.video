<?php
global $wps5_option;
?>
<div class="cr-product-block">
    <div class="shop-sub-options clearfix">
        <ul>
            <li class="col-xs-3 text-center">
                <a href="<?php echo $wps5_option['shipping_link'] ? $wps5_option['shipping_link'] : 'javascript:void(0)'; ?>">
                    <div class="option-icon"><i class="fa fa-truck fa-2x"></i></div>
                    <div class="option-text">Доставка вовремя</div>
                </a>
            </li>
            <li class="col-xs-3 text-center">
                <a href="<?php echo $wps5_option['sale_link'] ? $wps5_option['sale_link'] : 'javascript:void(0)'; ?>">
                    <div class="option-icon"><i class="fa fa-thumbs-o-up fa-2x"></i></div>
                    <div class="option-text">Нашли дешевле? Снизим цену!</div>
                </a>
            </li>
            <li class="col-xs-3 text-center">
                <a href="<?php echo $wps5_option['shop_link'] ? $wps5_option['shop_link'] : get_home_url().'/shop/'; ?>">
                    <div class="option-icon"><i class="fa fa-shopping-cart fa-2x"></i></div>
                    <div class="option-text">Полный каталог на mvideo.ru</div>
                </a>
            </li>
            <li class="col-xs-3 text-center">
                <a href="<?php echo $wps5_option['request_link'] ? $wps5_option['request_link'] : 'javascript:void(0)'; ?>">
                    <div class="option-icon"><i class="fa fa-exchange  fa-2x"></i></div>
                    <div class="option-text">30 дней на обмен</div>
                </a>
            </li>
        </ul>
    </div>
</div>