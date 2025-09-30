// Combined essential scripts
(function($) {
    'use strict';

    // 1. Mobile Menu Functionality
    function initMobileMenu() {
        const menuToggle = $('#mobile-menu-toggle');
        const menuClose = $('#mobile-menu-close');
        const menuSidebar = $('#mobile-menu-sidebar');
        const menuOverlay = $('#mobile-menu-overlay');
        const body = $('body');
        
        if (!menuToggle.length) return;
        
        function openMenu() {
            menuSidebar.removeClass('translate-x-full');
            menuOverlay.removeClass('hidden');
            body.addClass('mobile-menu-open');
        }
        
        function closeMenu() {
            menuSidebar.addClass('translate-x-full');
            menuOverlay.addClass('hidden');
            body.removeClass('mobile-menu-open');
        }
        
        menuToggle.on('click', openMenu);
        menuClose.on('click', closeMenu);
        menuOverlay.on('click', closeMenu);
        
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') closeMenu();
        });
        
        $(window).on('resize', function() {
            if (window.innerWidth >= 1280) closeMenu();
        });
    }

    // 2. Header Scroll Functionality
    function initHeaderScroll() {
        const $header = $('.site-header');
        if (!$header.length) return;

        const stickyHeaderBackground = '<?php echo esc_js(yiontech_lms_get_theme_setting("sticky_header_background_color", "#1e40af")); ?>';
        const headerBackground = '<?php echo esc_js(yiontech_lms_get_theme_setting("header_background_color", "#1e40af")); ?>';
        const stickyHeader = '<?php echo esc_js(yiontech_lms_get_theme_setting("sticky_header", true)); ?>';
        const transparentHeader = '<?php echo esc_js(yiontech_lms_get_theme_setting("transparent_header", false)); ?>';

        if (stickyHeader !== '1') return;

        // Set initial state
        if (transparentHeader === '1' && $header.hasClass('header-transparent')) {
            $header.css({'background-color': 'transparent', 'box-shadow': 'none'});
        } else {
            $header.css({'background-color': headerBackground, 'box-shadow': 'none'});
        }

        // Scroll handler
        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 50) {
                $header.css({
                    'background-color': stickyHeaderBackground,
                    'box-shadow': '0 4px 6px rgba(0, 0, 0, 0.1)'
                }).addClass('scrolled');
            } else {
                if (transparentHeader === '1' && $header.hasClass('header-transparent')) {
                    $header.css({'background-color': 'transparent', 'box-shadow': 'none'}).removeClass('scrolled');
                } else {
                    $header.css({'background-color': headerBackground, 'box-shadow': 'none'}).removeClass('scrolled');
                }
            }
        });
    }

    // 3. Back to Top Functionality
    function initBackToTop() {
        const backToTop = $('#back-to-top');
        if (!backToTop.length) return;

        $(window).on('scroll', function() {
            if ($(window).scrollTop() > 100) {
                backToTop.addClass('visible');
            } else {
                backToTop.removeClass('visible');
            }
        });

        backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 800);
        });
    }

    // Initialize all components
    $(document).ready(function() {
        initMobileMenu();
        initHeaderScroll();
        initBackToTop();
    });

})(jQuery);