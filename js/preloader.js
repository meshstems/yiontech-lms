(function($) {
    'use strict';
    
    $(window).on('load', function() {
        console.log('Window loaded');
        // Ensure preloader exists
        if ($('#preloader').length) {
            console.log('Preloader found, delaying fade out');
            // Show preloader for at least 1.5 seconds to ensure visibility
            setTimeout(function() {
                $('#preloader').fadeOut('slow', function() {
                    $(this).remove();
                    console.log('Preloader removed');
                });
            }, 1500);
        } else {
            console.log('Preloader not found');
        }
    });
    
    // Fallback in case load event doesn't fire properly
    $(document).ready(function() {
        console.log('Document ready');
        // Longer fallback time
        setTimeout(function() {
            if ($('#preloader').length) {
                console.log('Preloader found in fallback, fading out');
                $('#preloader').fadeOut('slow', function() {
                    $(this).remove();
                });
            } else {
                console.log('Preloader not found in fallback');
            }
        }, 4000); // 4 seconds fallback
    });
})(jQuery);