(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Back to top button
        var backToTop = $('#back-to-top');
        var scrollThreshold = 100;
        
        // Check if button exists
        if (backToTop.length) {
            // Function to show the button
            function showButton() {
                backToTop.addClass('visible');
                // Force style application with !important
                backToTop.attr('style', 'opacity: 1 !important; visibility: visible !important; transform: translateY(0) !important; pointer-events: auto !important;');
            }
            
            // Function to hide the button
            function hideButton() {
                backToTop.removeClass('visible');
                // Force style application with !important
                backToTop.attr('style', 'opacity: 0 !important; visibility: hidden !important; transform: translateY(20px) !important; pointer-events: none !important;');
            }
            
            // Check if page is scrollable
            function isPageScrollable() {
                return document.body.scrollHeight > window.innerHeight;
            }
            
            // Show/hide button based on scroll position
            $(window).on('scroll', function() {
                var scrollTop = $(this).scrollTop();
                
                if (scrollTop > scrollThreshold) {
                    showButton();
                } else {
                    hideButton();
                }
            });
            
            // Also use scroll event with passive option for better performance
            window.addEventListener('scroll', function() {
                var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                if (scrollTop > scrollThreshold) {
                    showButton();
                } else {
                    hideButton();
                }
            }, { passive: true });
            
            // Smooth scroll to top when button is clicked
            backToTop.on('click', function(e) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: 0
                }, 800);
            });
            
            // Initial check in case page is already scrolled
            setTimeout(function() {
                var initialScrollTop = $(window).scrollTop();
                
                // If page is not scrollable, show the button after a delay
                if (!isPageScrollable()) {
                    setTimeout(showButton, 2000);
                } else if (initialScrollTop > scrollThreshold) {
                    showButton();
                } else {
                    hideButton();
                }
            }, 100);
        }
    });
})(jQuery);