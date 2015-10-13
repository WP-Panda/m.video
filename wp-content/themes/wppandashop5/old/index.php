<?php

    require('./parts/product/product.php');
    
    // Define the root folder and base URL for the application
    function baseURL(){
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            dirname($_SERVER['REQUEST_URI'])
        );
    }

    define('BASE_URL', baseURL());
    define('RB_ROOT', dirname(__FILE__));
    $page = isset($_GET['page']) ? $_GET['page'] : 'fashion-v1';
    $layout = isset($_GET['layout']) ? $_GET['layout'] : 'fluid';

    
    if($page == 'box'){
         $layout = 'boxed';
    }
    
    $pages = array( 
        'fashion-v1' => 'Fashion-v1',
        'fashion-v2' => 'Fashion-v2',
        'fashion-v3' => 'Fashion-v3',
        'fashion-v3' => 'Fashion-v4',
        'fashion-v3' => 'Fashion-v5',
        'fashion-v3' => 'Fashion-v6',
        'blog-single' => 'Blog Single',
        'blog' => 'Blog',
        'box' => 'Box',
        'cart' => 'Cart',
        'checkout' => 'Checkout',
        'contact-us' => 'Contact Us',
        'details-v1' => 'Detail V1',
        'details-v2' => 'Detail V2',
        'digital' => 'Digital',
        'food' => 'Food',
        'furniture' => 'Furniture',
        'category-v1' => 'category V1',
        'category-v2' => 'category V2',
        'category-v3' => 'category V3',
        'handtools' => 'Handtools'
        );
    $pageTitle = isset( $pages[$page] ) ? $pages[$page] . ' | ' : '';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle ; ?>RimBus</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="assets/css/yamm.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    
    <link href="assets/css/main.css" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Raleway:100,200,400,300,500,600,800,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:400,900' rel='stylesheet' type='text/css'>

    <link rel="shortcut icon" href="assets/images/favicon.png">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
 
      
    <?php require RB_ROOT.'/layouts/'.$layout.'.php'; ?>

    <script src="assets/js/jquery-1.11.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
    <script src="assets/js/jquery.custom-select.js"></script>
    <script src="assets/js/echo.min.js"></script>
    <script src="assets/js/lightbox.min.js"></script>
    <script src="assets/js/pace.min.js"></script>
    <script src="assets/js/jquery.easing-1.3.min.js"></script>
    <script src="assets/js/wow.min.js"></script>

    <script src="assets/js/scripts.js"></script>

</body>
</html>