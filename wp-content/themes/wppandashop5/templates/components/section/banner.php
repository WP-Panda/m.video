<?php
global $wps5_option;

$home_bunner = $wps5_option['home_bunner'];

$h_b_4_h4 = $wps5_option['h_b_4_h4'];
$h_b_4_h2 = $wps5_option['h_b_4_h2'];
$h_b_4_i  = $wps5_option['h_b_4_i'];
$h_b_4_l  = $wps5_option['h_b_4_l'];

if( 'on' == $wps5_option['home_bunner_d'] ) {

    ?>
    <div class="banner-6x4 wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
        <div class="row">
            <div class="col-md-12 banner-1 wow fadeInUp animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="banner-outer">
                    <a href="<?php echo esc_url($h_b_4_l); ?>">
                        <div class="image">
                            <img src="<?php echo $h_b_4_i['url'] ?>" alt="" class="img-responsive">
                        </div>
                        <div class="text">
                            <h2><?php echo $h_b_4_h4 ?></h2>
                            <h4><?php echo $h_b_4_h2 ?></h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>