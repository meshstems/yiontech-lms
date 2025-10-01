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
    // Initialize all components
    $(document).ready(function() {
        initMobileMenu();
    });

})(jQuery);