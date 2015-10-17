<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="assets/images/favicon.png">

    <?php wp_head(); ?>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
<?php global $wps5_option;
if( !empty( $wps5_option['site_layout_mode'] && 'box' === $wps5_option['site_layout_mode']) ) {
    echo '<div class="box-wrapper">
		        <div class="custom-container">
			        <div class="wrapper-body-inner">';

} else {
    echo '<div id="wrapper" class="rimbus">';
}

$header= !empty($wps5_option['header_layout']) ? $wps5_option['header_layout'] : 1;
get_template_part( 'templates/headers/header','v' . $header );
if(is_home() || is_front_page()) {
    get_template_part('templates/components/section/slider', '');
}

