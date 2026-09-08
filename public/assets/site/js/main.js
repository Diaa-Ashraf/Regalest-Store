/*  ---------------------------------------------------
    Template Name: Ogani
    Description:  Ogani eCommerce  HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.featured__controls li').on('click', function () {
            $('.featured__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.featured__filter').length > 0) {
            var containerEl = document.querySelector('.featured__filter');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Humberger Menu - Enhanced
    $(".humberger__open").on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(".humberger__menu__wrapper").addClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");

        // Copy desktop menu to mobile menu
        if ($('.humberger__menu__nav ul').length === 0) {
            var desktopMenu = $('.header__menu ul').clone();
            desktopMenu.find('.header__menu__dropdown').removeClass('header__menu__dropdown').addClass('mobile-submenu');
            $('.humberger__menu__nav').html('<ul>' + desktopMenu.html() + '</ul>');

            // Add click handlers for mobile submenu
            $('.humberger__menu__nav ul li').each(function() {
                var $this = $(this);
                if ($this.find('.mobile-submenu').length > 0) {
                    $this.children('a').on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        $('.mobile-submenu').not($this.find('.mobile-submenu')).slideUp(300);
                        $this.find('.mobile-submenu').slideToggle(300);
                    });
                }
            });
        }
    });

    $(".humberger__menu__overlay").on('click', function () {
        $(".humberger__menu__wrapper").removeClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    // Close menu with ESC key
    $(document).on('keydown', function(e) {
        if (e.keyCode === 27) { // ESC key
            $(".humberger__menu__wrapper").removeClass("show__humberger__menu__wrapper");
            $(".humberger__menu__overlay").removeClass("active");
            $("body").removeClass("over_hid");
        }
    });

    /*------------------
  Navigation - Enhanced
 --------------------*/
    // Handle desktop dropdown menus better
    $('.header__menu ul li').on('mouseenter', function() {
        var $this = $(this);
        if ($this.find('.header__menu__dropdown').length > 0) {
            $this.find('.header__menu__dropdown').stop(true, true).slideDown(200);
        }
    });

    $('.header__menu ul li').on('mouseleave', function() {
        var $this = $(this);
        if ($this.find('.header__menu__dropdown').length > 0) {
            $this.find('.header__menu__dropdown').stop(true, true).slideUp(200);
        }
    });

    // Prevent dropdown from closing when clicking inside
    $('.header__menu__dropdown').on('click', function(e) {
        e.stopPropagation();
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.header__menu ul li').length) {
            $('.header__menu__dropdown').slideUp(200);
        }
    });

    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

 /*-----------------------
        Categories Slider
    ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            }
        }
    });

    $('.hero__categories__all').on('click', function(){
        $('.hero__categories ul').slideToggle(400);
    });

    /*--------------------------
        Latest Product Slider
    ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'></span>", "<span class='fa fa-angle-right'></span>"],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------------
        Product Discount Slider
    -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            }
        }
    });

    /*---------------------------------
        Product Details Pic Slider
    ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------
		Price Range Slider
	------------------------ */
    /*-----------------------
		Price Range Slider
	------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data('min') || 0,
        maxPrice = rangeSlider.data('max') || 5000,
        currentMin = rangeSlider.data('current-min') || minPrice,
        currentMax = rangeSlider.data('current-max') || maxPrice;

    if (rangeSlider.length > 0) {
        rangeSlider.slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            values: [currentMin, currentMax],
            slide: function (event, ui) {
                minamount.val('$' + ui.values[0]);
                maxamount.val('$' + ui.values[1]);
            }
        });
        minamount.val('$' + rangeSlider.slider("values", 0));
        maxamount.val('$' + rangeSlider.slider("values", 1));
    }

    // Failsafe for preloader
    setTimeout(function() {
        $(".loader").fadeOut();
        $("#preloder").fadeOut("slow");
    }, 3000);

    /*--------------------------
        Select
    ----------------------------*/
    $("select").niceSelect();

    /*------------------
		Single Product
	--------------------*/
    $('.product__details__pic__slider img').on('click', function () {

        var imgurl = $(this).data('imgbigurl');
        var bigImg = $('.product__details__pic__item--large').attr('src');
        if (imgurl != bigImg) {
            $('.product__details__pic__item--large').attr({
                src: imgurl
            });
        }
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });

    // Initialize mobile menu on page load
    $(document).ready(function() {
        // Only initialize mobile menu structure, don't show it automatically
        if ($(window).width() <= 991) {
            // Hide desktop menu
            $('.header__menu').hide();

            // Ensure mobile menu is properly initialized
            if ($('.humberger__menu__nav ul').length === 0) {
                var desktopMenu = $('.header__menu ul').clone();
                desktopMenu.find('.header__menu__dropdown').removeClass('header__menu__dropdown').addClass('mobile-submenu');
                $('.humberger__menu__nav').html('<ul>' + desktopMenu.html() + '</ul>');

                // Add click handlers for mobile submenu
                $('.humberger__menu__nav ul li').each(function() {
                    var $this = $(this);
                    if ($this.find('.mobile-submenu').length > 0) {
                        $this.addClass('has-submenu');
                        $this.children('a').on('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            $('.mobile-submenu').not($this.find('.mobile-submenu')).slideUp(300);
                            $this.toggleClass('open');
                            $this.find('.mobile-submenu').slideToggle(300);
                        });
                    }
                });
            }

            // Don't show mobile menu by default - only show when button is clicked
            // $('.humberger__menu__wrapper').removeClass("show__humberger__menu__wrapper");
            // $('.humberger__menu__overlay').removeClass("active");
            // $("body").removeClass("over_hid");
        }
    });

    // Handle window resize
    $(window).on('resize', function() {
        if ($(window).width() <= 991) {
            $('.humberger__open').show();
            $('.header__menu').hide();
        } else {
            $('.humberger__open').hide();
            $('.header__menu').show();
            $('.humberger__menu__wrapper').removeClass("show__humberger__menu__wrapper");
            $('.humberger__menu__overlay').removeClass("active");
            $('body').removeClass("over_hid");
        }
    });

})(jQuery);
