(function($) {
    "use strict";

    /*===================================================================================*/
    /*  owl carousel
     /*===================================================================================*/
    $(document).ready(function () {
        var dragging = true;
        var owlElementID = "#owl-main";

        function fadeInReset() {
            if (!dragging) {
                $(owlElementID + " .caption .fadeIn-1, " + owlElementID + " .caption .fadeIn-2, " + owlElementID + " .caption .fadeIn-3," + owlElementID + " .caption .fadeIn-4").stop().delay(800).animate({ opacity: 0 }, { duration: 400, easing: "easeInCubic" });
            }
            else {
                $(owlElementID + " .caption .fadeIn-1, " + owlElementID + " .caption .fadeIn-2, " + owlElementID + " .caption .fadeIn-3," + owlElementID + " .caption .fadeIn-4").css({ opacity: 0 });
            }
        }

        function fadeInDownReset() {
            if (!dragging) {
                $(owlElementID + " .caption .fadeInDown-1, " + owlElementID + " .caption .fadeInDown-2, " + owlElementID + " .caption .fadeInDown-3," + owlElementID + " .caption .fadeInDown-4").stop().delay(800).animate({ opacity: 0, top: "-15px" }, { duration: 400, easing: "easeInCubic" });
            }
            else {
                $(owlElementID + " .caption .fadeInDown-1, " + owlElementID + " .caption .fadeInDown-2, " + owlElementID + " .caption .fadeInDown-3," +  owlElementID + " .caption .fadeInDown-4").css({ opacity: 0, top: "-15px" });
            }
        }

        function fadeInUpReset() {
            if (!dragging) {
                $(owlElementID + " .caption .fadeInUp-1, " + owlElementID + " .caption .fadeInUp-2, " + owlElementID + " .caption .fadeInUp-3," + owlElementID + " .caption .fadeInUp-4").stop().delay(800).animate({ opacity: 0, top: "15px" }, { duration: 400, easing: "easeInCubic" });
            }
            else {
                $(owlElementID + " .caption .fadeInUp-1, " + owlElementID + " .caption .fadeInUp-2, " + owlElementID + " .caption .fadeInUp-3," + owlElementID + " .caption .fadeInUp-4").css({ opacity: 0, top: "15px" });
            }
        }

        function fadeInLeftReset() {
            if (!dragging) {
                $(owlElementID + " .caption .fadeInLeft-1, " + owlElementID + " .caption .fadeInLeft-2, " + owlElementID + " .caption .fadeInLeft-3, " + owlElementID + " .caption .fadeInLeft-4").stop().delay(800).animate({ opacity: 0, left: "15px" }, { duration: 400, easing: "easeInCubic" });
            }
            else {
                $(owlElementID + " .caption .fadeInLeft-1, " + owlElementID + " .caption .fadeInLeft-2, " + owlElementID + " .caption .fadeInLeft-3," + owlElementID + " .caption .fadeInLeft-4").css({ opacity: 0, left: "15px" });
            }
        }

        function fadeInRightReset() {
            if (!dragging) {
                $(owlElementID + " .caption .fadeInRight-1, " + owlElementID + " .caption .fadeInRight-2, " + owlElementID + " .caption .fadeInRight-3," + owlElementID + " .caption .fadeInRight-4").stop().delay(800).animate({ opacity: 0, left: "-15px" }, { duration: 400, easing: "easeInCubic" });
            }
            else {
                $(owlElementID + " .caption .fadeInRight-1, " + owlElementID + " .caption .fadeInRight-2, " + owlElementID + " .caption .fadeInRight-3," + owlElementID + " .caption .fadeInRight-4").css({ opacity: 0, left: "-15px" });
            }
        }

        function fadeIn() {
            $(owlElementID + " .active .caption .fadeIn-1").stop().delay(500).animate({ opacity: 1 }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeIn-2").stop().delay(700).animate({ opacity: 1 }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeIn-3").stop().delay(1000).animate({ opacity: 1 }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeIn-4").stop().delay(1000).animate({ opacity: 1 }, { duration: 800, easing: "easeOutCubic" });
        }

        function fadeInDown() {
            $(owlElementID + " .active .caption .fadeInDown-1").stop().delay(500).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInDown-2").stop().delay(700).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInDown-3").stop().delay(1000).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInDown-4").stop().delay(1000).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
        }

        function fadeInUp() {
            $(owlElementID + " .active .caption .fadeInUp-1").stop().delay(500).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInUp-2").stop().delay(700).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInUp-3").stop().delay(1000).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInUp-4").stop().delay(1000).animate({ opacity: 1, top: "0" }, { duration: 800, easing: "easeOutCubic" });
        }

        function fadeInLeft() {
            $(owlElementID + " .active .caption .fadeInLeft-1").stop().delay(500).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInLeft-2").stop().delay(700).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInLeft-3").stop().delay(1000).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInLeft-4").stop().delay(1000).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
        }

        function fadeInRight() {
            $(owlElementID + " .active .caption .fadeInRight-1").stop().delay(500).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInRight-2").stop().delay(700).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInRight-3").stop().delay(1000).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
            $(owlElementID + " .active .caption .fadeInRight-4").stop().delay(1000).animate({ opacity: 1, left: "0" }, { duration: 800, easing: "easeOutCubic" });
        }

        $(owlElementID).owlCarousel({
            animateOut: 'fadeOut',
            autoplay: false,
            autoplayTimeout: 2000,
            autoplayHoverPause: true,
            stopOnHover: true,
            loop: true,
            navRewind: true,
            items: 1,
            dots: true,
            nav:false,
            //navText: ["<i class='icon fa fa-angle-left'></i>", "<i class='icon fa fa-angle-right'></i>"],
            lazyLoad: true,
            stagePadding: 0,
            responsive : {
                0 : {
                    items : 1,
                },
                480: {
                    items : 1,
                },
                768 : {
                    items : 1,
                },
                992 : {
                    items : 1,
                },
                1199 : {
                    items : 1,
                },
                onTranslate : function(){
                    echo.render();
                }
            },


            onInitialize   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onInitialized   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onResize   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onResized   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onRefresh   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onRefreshed   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onUpdate   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onUpdated   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onDrag : function() {
                dragging = true;
            },

            onTranslate   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },
            onTranslated   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onTo   : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onChange    : function() {
                fadeIn();
                fadeInDown();
                fadeInUp();
                fadeInLeft();
                fadeInRight();
            },

            onChanged  : function() {
                fadeInReset();
                fadeInDownReset();
                fadeInUpReset();
                fadeInLeftReset();
                fadeInRightReset();
                dragging = false;
            }
        });

        $('.banner-slider').owlCarousel({
            loop:true,
            margin:30,
            autoplay: true,
            nav:false,
            dots: true,
            navText: ["", ""],
            items:1,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:1
                }
            }
        });
        $('.clients-say').owlCarousel({
            loop:true,
            margin:30,
            autoplay: true,
            nav:true,
            navText: ["", ""],
            items:1,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
        $('.blog-slider-content').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            navText: ["", ""],
            items:3,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        });
        $('.blog-single').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            navText: ["", ""],
            items:1,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
        $('.product-item-small-owl').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            navText: ["", ""],
            items:1,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:1
                }
            }
        });
        $('.testimonial').owlCarousel({
            loop:true,
            margin:10,
            nav:false,
            navText: ["", ""],
            items:1,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });

        $('#client-testimonial').owlCarousel({
            loop:true,
            margin:10,
            nav:false,
            dots:true,
            items:1,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });

        $('.hot-sale-slider').owlCarousel({
            loop:true,
            margin:10,
            nav:false,
            dots:true,

            items:1,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
        $('.our-brands').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            navText: ["", ""],
            items:5,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });
        $('.our-brands-v2').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            navText: ["", ""],
            items:6,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:6
                }
            }
        });

        $('.handtool-featured').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            navText: ["", ""],
            items:3,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:3
                }
            }
        });

        $('.digital-new').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            navText: ["", ""],
            items:5,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });
        $('.new-furniture-product').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            navText: ["", ""],
            items:5,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });
        $('.box-new').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            navText: ["", ""],
            items:5,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });

        $('.featured-product').owlCarousel({

            loop:true,
            margin:30,
            nav:true,
            navText: ["", ""],
            items:4,
            dots:false,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:4
                }
            }
        });

        $('.single-product-tabs').on('shown.bs.tab', function(){
            $(this).parent().find('.tab-pane.active .home-carousel').owlCarousel({
                items : 4,
                nav:true,
                navText: ["", ""],
                margin:30,
                slideSpeed : 300,
                dots: true,
                paginationSpeed : 400,
                responsive:{
                    0:{
                        items:1,
                    },
                    600:{
                        items:2,
                    },
                    1000:{
                        items:3,
                    },
                    1280:{
                        items:4,
                    }

                }
            });

        });

        $('.single-digital-product-tabs').on('shown.bs.tab', function(){
            $(this).parent().find('.tab-pane.active .digital-featured').owlCarousel({
                items : 5,
                nav:true,
                navText: ["", ""],
                margin:30,
                slideSpeed : 300,
                dots: true,
                paginationSpeed : 400,
                responsive:{
                    0:{
                        items:1,
                    },
                    600:{
                        items:2,
                    },
                    1000:{
                        items:3,
                    },
                    1280:{
                        items:5,
                    }

                }
            });

        });

        $('.handtool-product-tab').on('shown.bs.tab', function(){
            $(this).parent().find('.tab-pane.active .handtool-featured1').owlCarousel({
                items : 3,
                nav:true,
                navText: ["", ""],
                margin:30,
                slideSpeed : 300,
                dots: true,
                paginationSpeed : 400,
                responsive:{
                    0:{
                        items:1,
                    },
                    600:{
                        items:2,
                    },
                    1000:{
                        items:3,
                    },
                    1280:{
                        items:3,
                    }

                }
            });

        });

        $('.furniture-product-tabs').on('shown.bs.tab', function(){
            $(this).parent().find('.tab-pane.active .furniture-featured-product').owlCarousel({
                loop:true,
                margin:30,
                nav:true,
                navText: ["", ""],
                items:5,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:5
                    }
                }
            });

        });

        $('.box-product-tabs').on('shown.bs.tab', function(){
            $(this).parent().find('.tab-pane.active .box-featured').owlCarousel({
                loop:true,
                margin:30,
                nav:true,
                navText: ["", ""],
                items:5,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:5
                    }
                }
            });

        });

        var $sync1 = $('#owl-single-product'),
            $sync2 = $('#owl-single-product-thumbnails'),
            flag = false,
            duration = 300;

        $sync1
            .owlCarousel({
                items: 1,
                margin: 10,
                nav: false,
                dots: true,
            })
            .on('changed.owl.carousel', function (e) {
                if (!flag) {
                    flag = true;
                    $sync2.trigger('to.owl.carousel', [e.item.index, duration, true]);
                    flag = false;
                }
            });

        $sync2
            .owlCarousel({
                margin: 20,
                items: 6,
                nav: true,
                autoWidth:true,
                dots: true,
                navigationText : [".","."],
            })
            .on('click', '.owl-item', function () {
                $sync1.trigger('to.owl.carousel', [$(this).index(), duration, true]);

            })
            .on('changed.owl.carousel', function (e) {
                if (!flag) {
                    flag = true;
                    $sync1.trigger('to.owl.carousel', [e.item.index, duration, true]);
                    flag = false;
                }
            });


        $(document).on('click', '.single-product-gallery .horizontal-thumb', function(e) {
            var $this = $(this), owl = $($this.data('target')), slideTo = $this.data('slide');
            owl.trigger('to.owl.carousel', slideTo);
            $this.addClass('active').parent().siblings().find('.active').removeClass('active');
            return false;
        });


        $('.fashion-v6-featured').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            dots:false,
            items:5,
            navText: ["", ""],
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:5
                }
            }
        });

        $('.sidebar-single-product').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            navText: ["", ""],
            autoplay: true,
            dots:false,
            items:1,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:1
                }
            }
        });

        /*===================================================================================*/
        /*  LAZY LOAD IMAGES USING ECHO
         /*===================================================================================*/

        echo.init({
            offset: 100,
            throttle: 250,
            unload: false
        });



        /*===================================================================================*/
        /* PRICE SLIDER
         /*===================================================================================*/

        // Price Slider
        if ($('.price-slider').length > 0) {
            $('.price-slider').slider({
                min: 100,
                max: 700,
                step: 10,
                value: [200, 500],
                handle: "square"

            });

        }


        /*===================================================================================*/
        /*  WOW
         /*===================================================================================*/

        var wow = new WOW(
            {
                boxClass:     'wow',      // animated element css class (default is wow)
                animateClass: 'animated', // animation css class (default is animated)
                offset:       0,          // distance to the element when triggering the animation (default is 0)
                mobile:       true,       // trigger animations on mobile devices (default is true)
                live:         true,       // act on asynchronously loaded content (default is true)
                callback:     function(box) {
                    // the callback is fired every time an animation is started
                    // the argument that is passed in is the DOM node being animated
                }
            }
        );
        wow.init();


        /*===================================================================================*/
        /*  TOOLTIP
         /*===================================================================================*/
        $("[data-toggle='tooltip']").tooltip();
        $(document).on('click', '#transitionType li a', function(e) {
            $('#transitionType li a').removeClass('active');
            $(this).addClass('active');

            var newValue = $(this).attr('data-transition-type');

            $(owlElementID).data("owlCarousel").transitionTypes(newValue);
            $(owlElementID).trigger("owl.next");

            return false;

        });


        /*===================================================================================*/
        /*  custom select
         /*===================================================================================*/

        $('select.styled').customSelect();
    });

    /*===================================================================================*/
    /*  YAMM DROPDOWN
     /*===================================================================================*/
    $(document).on('click', '.yamm .dropdown-menu', function(e) {
        e.stopPropagation()
    });



    $('.fashion-v1-position').prev('header').addClass('behind-slider-h');
    $('.fashion-v1-position').next('footer').addClass('behind-slider-f');


    /*===================================================================================*/
    /* CART DROPDOWN
     /*===================================================================================*/
    $('#cart-drop').hover(
        function(){
            $(this).find('ul.dropdown-menu').fadeIn();
        },function() {
            $(this).find('ul.dropdown-menu').fadeOut();
        }
    );

    /**
     * ������ ����� ����� �������
     */
    $('.cr-product-block.cr-query-block').click(function(){
        $('.cr-query-hide').show();
    });

    /**
     * ������� ����� ����� �������
     */
    $('#query-hider').click(function(e){
        //e.preventDefault();
        //alert('sssssssssssssss');
        setTimeout(function(){
            $('.cr-query-hide').css({'display':'none'});
        },100);

    });

    /**
     * ������� � ������� �������
     */

    $.fn.extend({
        popoverClosable: function (options) {
            var defaults = {
                template:
                    '<div class="popover">\
    <div class="arrow"></div>\
    <div class="popover-header">\
    <button type="button" class="close" data-dismiss="popover" aria-hidden="true">&times;</button>\
    <h3 class="popover-title"></h3>\
    </div>\
    <div class="popover-content"></div>\
    </div>'
            };
            options = $.extend({}, defaults, options);
            var $popover_togglers = this;
            $popover_togglers.popover(options);
            $popover_togglers.on('click', function (e) {
                e.preventDefault();
                $popover_togglers.not(this).popover('hide');
            });
            $('html').on('click', '[data-dismiss="popover"]', function (e) {
                $popover_togglers.popover('hide');
            });
        }
    });

    $('[data-toggle="popover"]').popoverClosable({html:true});


    /**************************************
     *  со ссылки на таб
     */

    $(document).on('click','.inner-tabber',function(e){
        e.preventDefault();
        var $target = $(this).attr('href');

        $('.tabs li').each(function(){
            if( $(this).find('a[href=' + $target + ']').length ) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }

            $('.wc-tab').hide();
            $($target).show();

            $('html,body').animate({
                scrollTop: $($target).offset().top - 100
            },500);
        });
    });

    /** Прокрутка к табу */
    /* $('.abbrer').click(function(){

     var $target = $(this).attr('href');

     $('html,body').animate({
     scrollTop: $($target).offset().top
     },500);

     });*/

    $('.owl-news').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });

    /**
     * Выравнивание ширины колонок
     */

    function resizer() {
        var $width_container = $('.search-result-container').width(),
            $width_item = $('.prod-list:eq(0)').width(),
            $count_in_row = parseInt($width_container / $width_item),
            $count_items = $('.prod-list').length,
            $rows_count = $count_items / $count_in_row,
            $n = 1,
            $a = 0;


        $('.prod-list').each(function (i) {

            if ($n % $count_in_row == 1) $a++;
            $(this).find('.priser-conta').addClass('flag-span-' + $a);
            $(this).find('.discounses').addClass('flag-discounses-' + $a);
            $(this).find('.image').addClass('flag-image-' + $a);


            if ($n % $count_in_row == 0) {
                var mainDivs = document.getElementsByClassName('flag-span-' + $a);
                var maxHeight = 0;
                for (var i = 0; i < mainDivs.length; ++i) {
                    if (maxHeight < mainDivs[i].clientHeight) {
                        maxHeight = mainDivs[i].clientHeight;
                    }
                }
                for (var i = 0; i < mainDivs.length; ++i) {
                    mainDivs[i].style.height = maxHeight + "px";
                }



                var mainDivsd = document.getElementsByClassName('flag-discounses-' + $a);
                var maxHeightd = 0;
                for (var i = 0; i < mainDivsd.length; ++i) {
                    if (maxHeightd < mainDivsd[i].clientHeight) {
                        maxHeightd = mainDivsd[i].clientHeight;
                    }
                }
                for (var i = 0; i < mainDivsd.length; ++i) {
                    mainDivsd[i].style.height = maxHeightd + "px";
                }

                var mainDivsd4 = document.getElementsByClassName('flag-image-' + $a);
                var maxHeightd4 = 0;
                for (var i = 0; i < mainDivsd4.length; ++i) {
                    if (maxHeightd4 < mainDivsd4[i].clientHeight) {
                        maxHeightd4 = mainDivsd4[i].clientHeight;
                    }
                }
                for (var i = 0; i < mainDivsd4.length; ++i) {
                    mainDivsd4[i].style.height = maxHeightd4 + "px";
                }

            }

            $n++;
        });
    }
    resizer();
    $(window).resize(function () {
        resizer();
    });

    $(document).on('click','.woof_container h4',function(){
        $(this).addClass('hid');
        $(this).next('div').slideUp();
    });

    $(document).on('click','.woof_container h4.hid',function(){
        $(this).removeClass('hid');
        $(this).next('div').slideDown();
    });


    $('.mega-item').hover(
        function(){
            $('.o-100').css({
                height:$(this).find('.wr-megamenu-inner').height()+100,
                top:$(this).find('.wr-megamenu-inner').offset().top-3
            }).show();
        },function(){
            $('.o-100').hide();
        });

})(jQuery);

