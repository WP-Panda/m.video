<?php
global $wps5_option;

$home_bunner = $wps5_option['home_bunner'];

$h_b_1_h4 = $wps5_option['h_b_1_h4'];
$h_b_1_h2 = $wps5_option['h_b_1_h2'];
$h_b_1_i  = $wps5_option['h_b_1_i'];
$h_b_1_l  = $wps5_option['h_b_1_l'];

$h_b_2_h4 = $wps5_option['h_b_2_h4'];
$h_b_2_h2 = $wps5_option['h_b_2_h2'];
$h_b_2_i  = $wps5_option['h_b_2_i'];
$h_b_2_l  = $wps5_option['h_b_1_l'];

$h_b_3_h4 = $wps5_option['h_b_3_h4'];
$h_b_3_h2 = $wps5_option['h_b_3_h2'];
$h_b_3_i  = $wps5_option['h_b_3_i'];
$h_b_3_l  = $wps5_option['h_b_1_l'];

if( 'on' == $wps5_option['home_bunner'] ) {

    ?>
    <div class="banner-non-link wow fadeInUp">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12 banner-1 wow fadeInUp" data-wow-delay="0.2s">
                <div class="banner-outer">
                    <a href="<?php echo esc_url($h_b_1_l); ?>">
                        <div class="image">
                            <img src="<?php echo $h_b_1_i['url'] ?>" class="img-responsive" alt="#">
                        </div>
                        <div class="text">
                            <h4><?php echo $h_b_1_h4 ?></h4>
                            <h2><?php echo $h_b_1_h2 ?></h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12 banner-2 wow fadeInUp" data-wow-delay="0.4s">
                <div class="banner-outer ">
                    <a href="<?php echo esc_url($h_b_2_l); ?>">
                        <div class="image">
                            <img src="<?php echo $h_b_2_i['url'] ?>" alt="#" class="img-responsive">
                        </div>
                        <div class="text">
                            <h4><?php echo $h_b_2_h4 ?></h4>
                            <h2><?php echo $h_b_2_h2 ?></h2>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 banner-3 wow fadeInUp" data-wow-delay="0.6s">
                <div class="banner-outer">
                    <a href="<?php echo esc_url($h_b_3_l); ?>">
                        <div class="image">
                            <img src="<?php echo $h_b_3_i['url'] ?>" alt="#" class="img-responsive">
                        </div>
                        <div class="text">
                            <h4><?php echo $h_b_3_h4 ?></h4>
                            <h2><?php echo $h_b_3_h2 ?></h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>