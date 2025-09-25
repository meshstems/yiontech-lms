(function($) {
    'use strict';
    
    $(document).ready(function() {
        const $header = $('.site-header');
        const $window = $(window);
        const stickyHeaderBackground = '<?php echo esc_js(yiontech_lms_get_theme_setting("sticky_header_background_color", "#1e40af")); ?>';
        const headerBackground = '<?php echo esc_js(yiontech_lms_get_theme_setting("header_background_color", "#1e40af")); ?>';
        const stickyHeader = '<?php echo esc_js(yiontech_lms_get_theme_setting("sticky_header", true)); ?>';

        // Set initial background for transparent header
        if ($header.hasClass('header-transparent')) {
            $header.css('background-color', 'transparent');
        } else {
            $header.css('background-color', headerBackground);
        }

        // Only add scroll behavior if sticky header is enabled
        if (stickyHeader === '1') {
            $window.on('scroll', function() {
                const scrollTop = $window.scrollTop();

                if (scrollTop > 50) {
                    $header.css({
                        'background-color': stickyHeaderBackground,
                        'box-shadow': '0 4px 6px rgba(0, 0, 0, 0.1)',
                        'transition': 'background-color 0.3s ease, box-shadow 0.3s ease'
                    });
                    $header.addClass('scrolled');
                } else {
                    $header.css({
                        'background-color': $header.hasClass('header-transparent') ? 'transparent' : headerBackground,
                        'box-shadow': 'none',
                        'transition': 'background-color 0.3s ease, box-shadow 0.3s ease'
                    });
                    $header.removeClass('scrolled');
                }
            });
        }
    });
})(jQuery);