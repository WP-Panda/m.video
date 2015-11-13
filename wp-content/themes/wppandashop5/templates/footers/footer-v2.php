<?php global $wps5_option;
$logo = $wps5_option['custom_admin_logo'];
$f 	= ( ! empty( $wps5_option['facebook-url'] ))	 ? $wps5_option['facebook-url'] 	: '' ;
$f1 = ( ! empty( $wps5_option['google-plus-url'] ))	 ? $wps5_option['google-plus-url']  : "" ;
$f2 = ( ! empty( $wps5_option['twitter-url'] ))		 ? $wps5_option['twitter-url'] 		: "" ;
$f3 = ( ! empty( $wps5_option['youtube-url'] ))	 	 ? $wps5_option['youtube-url'] 		: "" ;
$cop = ( ! empty( $wps5_option['footer_credits_text'] ))	? $wps5_option['footer_credits_text'] : '<p class="copy-rights"><i class="fa fa-copyright"></i> 2015 <a href="http://wp-panda.com">WP Panda</a></p>' ;
?>
<footer>
	<div class="footer-v2">
		<div class="footer-outer-1">
			<div class="container">
				<div class="row">

					<div class="col-xs-12 col-sm-4 col-md-2">
						<?php
						if ( function_exists('dynamic_sidebar') )
							dynamic_sidebar('footer-1');
						?>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-2">
						<?php
						if ( function_exists('dynamic_sidebar') )
							dynamic_sidebar('footer-2');
						?>
					</div>

					<div class="col-xs-12 col-sm-4 col-md-2">
						<?php
						if ( function_exists('dynamic_sidebar') )
							dynamic_sidebar('footer-3');
						?>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-2">
						<?php
						if ( function_exists('dynamic_sidebar') )
							dynamic_sidebar('footer-4');
						?>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-4 company-info">
						<div class="logo">
							<?php
							if( ! empty( $logo ) ) {
								echo '<a href="' . home_url() . '" alt="' . get_bloginfo('name'). '"><img class="logo" src="' . $logo['url'] . '" title="' . get_bloginfo('name'). '"></a>';
							} else {
								get_template_part('templates/components/footer/logo','mixed');
							}
							?>
						</div>
						<?php
						if ( function_exists('dynamic_sidebar') )
							dynamic_sidebar('footer-5');
						?>
						<div class="social-network">
							<h4 class="title">В социальных сетях</h4>
							<div class="footer-social">
								<ul class="social-links list-unstyled list-inline">
									<?php if(!empty($f)) { ?>
									<li><a href="<?php echo $f ?>" class="link"><span class="icon facebook"><i class="fa fa-facebook"></i></span></a></li>
									<?php } ?>
									<?php if(!empty($f1)) { ?>
									<li><a href="<?php echo $f1 ?>" class="link"><span class="icon google-plus"><i class="fa fa-google-plus"></i></span></a></li>
									<?php } ?>
									<?php if(!empty($f2)) { ?>
									<li><a href="<?php echo $f2 ?>" class="link"><span class="icon twitter"><i class="fa fa-twitter"></i></span></a></li>
									<?php } ?>
									<?php if(!empty($f3)) { ?>
									<li><a href="<?php echo $f3 ?>" class="link"><span class="icon tumblr"><i class="fa fa-tumblr"></i></span></a></li>
									<?php } ?>

								</ul>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="footer-outer-2 outer-top-vs">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-6">
						<?php echo $cop ?>
					</div>
					<div class="col-xs-12 col-sm-5 col-md-6 payment-card">
						<ul class="payment-link list-unstyled list-inline">
							<li><a href="javascript:void(0);"><img src="<?php get_home_url(); ?>/wp-content/themes/wppandashop5/assets/images/payments/master.png" alt="#"></a></li>
							<li><a href="javascript:void(0);"><img src="<?php get_home_url(); ?>/wp-content/themes/wppandashop5/assets/images/payments/visa.png" alt=""></a></li>
							<li><a href="http://wp-panda.com/" data-toggle="tooltip" data-placement="top" title="Создание сайта"><img style="width: 50px;" src="http://wp-panda.com/wp-content/uploads/2015/03/pandalogo.png" alt="Создание сайта"></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

</footer>