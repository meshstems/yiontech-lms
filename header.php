<?php
/**
 * Header template for Yiontech LMS
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-md sticky top-0 z-50">
    <?php 
    if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'header' ) ) {
        // Elementor header
    } else {
        // Default theme header
        ?>
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-3">
                <!-- Logo (Left) -->
                <div class="site-branding flex items-center">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php the_custom_logo(); ?>
                    <?php else : ?>
                        <h1 class="text-xl font-bold">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-white">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                    <?php endif; ?>
                </div>
                
                <!-- Desktop Navigation (Center) -->
                <nav id="site-navigation" class="main-navigation hidden xl:flex flex-1 justify-center">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'flex space-x-8 items-center',
                        'container'      => false,
                    ) );
                    ?>
                </nav>
                
                <!-- Right Side Buttons -->
                <div class="flex items-center space-x-3">
                    <!-- Login Button (Desktop Only) -->
                    <a href="<?php echo esc_url( home_url( '/login' ) ); ?>" class="hidden xl:block px-4 py-1.5 text-sm rounded-lg border border-white hover:bg-white hover:text-blue-600 transition duration-300">Login</a>
                    
                    <!-- Enquire Now Button -->
                    <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="px-4 py-1.5 text-sm rounded-lg bg-white text-blue-600 font-medium hover:bg-blue-50 transition duration-300">Enquire Now</a>
                    
                    <!-- Mobile Menu Toggle -->
                    <button id="mobile-menu-toggle" class="text-white focus:outline-none p-1">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</header>

<!-- Mobile Menu Overlay -->
<div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden"></div>

<!-- Mobile Menu Sidebar -->
<div id="mobile-menu-sidebar" class="fixed top-0 right-0 h-full w-80 bg-white z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full">
        <!-- Menu Header -->
        <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <div class="site-branding flex items-center">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <h2 class="text-xl font-bold"><?php bloginfo( 'name' ); ?></h2>
                <?php endif; ?>
            </div>
            <button id="mobile-menu-close" class="text-white focus:outline-none p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Menu Content -->
        <div class="flex-grow overflow-y-auto">
            <!-- Main Navigation -->
            <div class="p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Navigation</h3>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'space-y-2',
                    'container'      => false,
                ) );
                ?>
            </div>
            
            <!-- User Portal -->
            <div class="p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">User Portal</h3>
                <div class="space-y-3">
                    <a href="<?php echo esc_url( home_url( '/login' ) ); ?>" class="block px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition duration-300">Login</a>
                    <a href="<?php echo esc_url( home_url( '/register' ) ); ?>" class="block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Create Account</a>
                    <a href="<?php echo esc_url( home_url( '/dashboard' ) ); ?>" class="block px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-300">My Dashboard</a>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Quick Links</h3>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'footer-quick-links',
                    'menu_class'     => 'space-y-2',
                    'container'      => false,
                ) );
                ?>
            </div>
            
            <!-- Contact Information -->
            <div class="p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Contact Us</h3>
                <ul class="space-y-2 text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>info@yiontech.com</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>+1 (555) 123-4567</span>
                    </li>
                </ul>
            </div>
            
            <!-- Social Media -->
            <div class="p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Follow Us</h3>
                <div class="flex space-x-4">
                    <!-- your SVGs remain unchanged -->
                </div>
            </div>
            
            <!-- Newsletter Signup -->
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Newsletter</h3>
                <p class="text-gray-600 text-sm mb-3">Subscribe to get the latest updates and offers.</p>
                <form class="mt-2" action="#" method="post">
                    <div class="flex">
                        <input type="email" name="email" placeholder="Your email" 
                               class="flex-grow px-3 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Menu Footer -->
        <div class="p-4 bg-gray-100 border-t">
            <div class="text-center text-gray-600 text-sm">
                <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?></p>
                <p class="mt-1">All rights reserved.</p>
            </div>
        </div>
    </div>
</div>
