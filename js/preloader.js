/* ==========================
   Preloader Script
========================== */
(function ($) {
    'use strict';

    $(window).on('load', function () {
        if ($('#preloader').length) {
            // Remove preloader immediately when content is loaded
            $('#preloader').fadeOut('slow', function () {
                $(this).remove();
                $('body').removeClass('preloader-active');
                
                // Trigger event for other scripts that depend on preloader removal
                $(document).trigger('preloaderRemoved');
            });
        } else {
            $('body').removeClass('preloader-active');
            
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
                    
                    // Trigger event for other scripts that depend on preloader removal
                    $(document).trigger('preloaderRemoved');
                });
            } else if (!$('#preloader').length) {
                // Trigger event for consistency
                $(document).trigger('preloaderRemoved');
            }
        }, 1000);
    });

})(jQuery);