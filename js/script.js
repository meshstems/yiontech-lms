(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        // Save scroll position before page unload
        window.addEventListener('beforeunload', function() {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });
        
        // Get elements
        const menuToggle = document.getElementById('mobile-menu-toggle');
        const menuClose = document.getElementById('mobile-menu-close');
        const menuSidebar = document.getElementById('mobile-menu-sidebar');
        const menuOverlay = document.getElementById('mobile-menu-overlay');
        const body = document.body;
        
        // Check if elements exist
        if (!menuToggle || !menuClose || !menuSidebar || !menuOverlay) {
            console.error('Mobile menu elements not found');
            return;
        }
        
        // Open menu function
        function openMenu() {
            menuSidebar.classList.remove('translate-x-full');
            menuOverlay.classList.remove('hidden');
            // Prevent body scroll to avoid layout shifts
            body.classList.add('mobile-menu-open');
        }
        
        // Close menu function
        function closeMenu() {
            menuSidebar.classList.add('translate-x-full');
            menuOverlay.classList.add('hidden');
            // Restore body scroll
            body.classList.remove('mobile-menu-open');
        }
        
        // Toggle menu on button click
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault();
            if (menuSidebar.classList.contains('translate-x-full')) {
                openMenu();
            } else {
                closeMenu();
            }
        });
        
        // Close menu on close button click
        menuClose.addEventListener('click', function(e) {
            e.preventDefault();
            closeMenu();
        });
        
        // Close menu on overlay click
        menuOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            closeMenu();
        });
        
        // Close menu on escape key press
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !menuSidebar.classList.contains('translate-x-full')) {
                closeMenu();
            }
        });
        
        // Close menu on window resize if desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1280 && !menuSidebar.classList.contains('translate-x-full')) {
                closeMenu();
            }
        });
    });
})();