<?php
global $wps5_option;
$array = $wps5_option['home-slider'];
?>

<div class="hero-style-2" id="hero">
    <div class="big-slider owl-main owl-carousel owl-inner-nav owl-ui-lg" id="owl-main">

        <?php foreach( $array as $key ) { ?>

            <div class="item" style="background-image: url(<?php echo $key['image']; ?>);">
                <div class="container">
                    <div class="slider caption vertical-center text-right">
                        <h1 class="fadeInDown-1"><?php echo $key['title']; ?></h1>
                        <h6 class="fadeInDown-2"><?php echo $key['description']; ?></h6>
                        <div class="slide-btn fadeInDown-3">
                            <a href="#" class="btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
</div>