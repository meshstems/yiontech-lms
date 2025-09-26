/* ==========================
   Back To Top Script
========================== */
(function ($) {
    'use strict';

    function initBackToTop() {
        var backToTop = $('#back-to-top');
        var scrollThreshold = 100;

        if (!backToTop.length) return;

        // Show/hide button
        function toggleButton() {
            if ($(window).scrollTop() > scrollThreshold) {
                backToTop.addClass('visible');
            } else {
                backToTop.removeClass('visible');
            }
        }

        // Scroll listener with requestAnimationFrame
        let ticking = false;
        $(window).on('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(function () {
                    toggleButton();
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Initial state
        toggleButton();

        // Smooth scroll to top
        backToTop.on('click', function (e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 800);
        });
    }

    $(document).ready(function () {
        initBackToTop();
    });

})(jQuery);