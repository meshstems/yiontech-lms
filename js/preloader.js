/* ==========================
   Preloader Script
========================== */
(function ($) {
    'use strict';

    // Function to restore scroll position
    function restoreScrollPosition() {
        const scrollPosition = sessionStorage.getItem('scrollPosition');
        if (scrollPosition) {
            window.scrollTo(0, parseInt(scrollPosition));
            sessionStorage.removeItem('scrollPosition');
        }
    }

    $(window).on('load', function () {
        if ($('#preloader').length) {
            // Remove preloader immediately when content is loaded
            $('#preloader').fadeOut('slow', function () {
                $(this).remove();
                $('body').removeClass('preloader-active');
                
                // Restore scroll position after preloader is removed
                restoreScrollPosition();
                
                // Trigger event for other scripts that depend on preloader removal
                $(document).trigger('preloaderRemoved');
            });
        } else {
            $('body').removeClass('preloader-active');
            
            // Restore scroll position if no preloader
            restoreScrollPosition();
            
            // Trigger event for consistency
            $(document).trigger('preloaderRemoved');
        }
    });

    // Fallback in case window.load never triggers
    $(document).ready(function() {
        setTimeout(function() {
            if ($('#preloader').length && $('#preloader').is(':visible')) {
                $('#preloader').fadeOut('slow', function () {
                    $(this).remove();
                    $('body').removeClass('preloader-active');
                    
                    // Restore scroll position after preloader is removed
                    restoreScrollPosition();
                    
                    // Trigger event for other scripts that depend on preloader removal
                    $(document).trigger('preloaderRemoved');
                });
            } else if (!$('#preloader').length) {
                // Restore scroll position if no preloader
                restoreScrollPosition();
                
                // Trigger event for consistency
                $(document).trigger('preloaderRemoved');
            }
        }, 1000); // Reduced timeout to 1 second
    });

})(jQuery);