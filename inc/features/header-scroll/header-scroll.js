(function($) {
    'use strict';

    // Function to initialize header scroll functionality
    function initHeaderScroll() {
        const $header = $('.site-header');
        const $window = $(window);
        const stickyHeaderBackground = '<?php echo esc_js(yiontech_lms_get_theme_setting("sticky_header_background_color", "#1e40af")); ?>';
        const headerBackground = '<?php echo esc_js(yiontech_lms_get_theme_setting("header_background_color", "#1e40af")); ?>';
        const stickyHeader = '<?php echo esc_js(yiontech_lms_get_theme_setting("sticky_header", true)); ?>';
        const transparentHeader = '<?php echo esc_js(yiontech_lms_get_theme_setting("transparent_header", false)); ?>';

        // Only add scroll behavior if sticky header is enabled
        if (stickyHeader === '1') {
            // Set initial background without triggering transitions
            if (transparentHeader === '1' && $header.hasClass('header-transparent')) {
                $header.css({
                    'background-color': 'transparent',
                    'box-shadow': 'none'
                });
            } else {
                $header.css({
                    'background-color': headerBackground,
                    'box-shadow': 'none'
                });
            }
            
            // Force a reflow to apply the initial styles
            $header[0].offsetHeight;
            
            // Set initial state based on scroll position
            if ($window.scrollTop() > 50) {
                $header.css({
                    'background-color': stickyHeaderBackground,
                    'box-shadow': '0 4px 6px rgba(0, 0, 0, 0.1)'
                }).addClass('scrolled');
            }
            
            // Throttle scroll event for better performance
            let ticking = false;
            
            function updateHeader() {
                const scrollTop = $window.scrollTop();

                if (scrollTop > 50) {
                    $header.css({
                        'background-color': stickyHeaderBackground,
                        'box-shadow': '0 4px 6px rgba(0, 0, 0, 0.1)'
                    }).addClass('scrolled');
                } else {
                    if (transparentHeader === '1' && $header.hasClass('header-transparent')) {
                        $header.css({
                            'background-color': 'transparent',
                            'box-shadow': 'none'
                        }).removeClass('scrolled');
                    } else {
                        $header.css({
                            'background-color': headerBackground,
                            'box-shadow': 'none'
                        }).removeClass('scrolled');
                    }
                }
                
                ticking = false;
            }
            
            $window.on('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        updateHeader();
                        ticking = false;
                    });
                    ticking = true;
                }
            });
        }
    }

    // Initialize header scroll in multiple scenarios
    
    // Scenario 1: After preloader is removed (if preloader is enabled)
    $(document).on('preloaderRemoved', function() {
        initHeaderScroll();
    });
    
    // Scenario 2: On document ready (if preloader is disabled)
    $(document).ready(function() {
        // Check if preloader exists
        var preloader = $('#preloader');
        
        // If preloader doesn't exist or is not visible, initialize header scroll immediately
        if (!preloader.length || preloader.is(':hidden')) {
            // Wait a bit to ensure all other scripts are loaded
            setTimeout(function() {
                initHeaderScroll();
            }, 100);
        }
    });
    
    // Scenario 3: Fallback - ensure header scroll is initialized even if other methods fail
    $(window).on('load', function() {
        // Check if header scroll is already initialized
        var $header = $('.site-header');
        if ($header.length && !$header.hasClass('header-scroll-initialized')) {
            setTimeout(function() {
                initHeaderScroll();
                $header.addClass('header-scroll-initialized');
            }, 500);
        }
    });

})(jQuery);