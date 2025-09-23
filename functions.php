<?php
// Theme setup
function yiontech_lms_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 36,
        'width'       => 120,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Add Elementor support
    add_theme_support('elementor');
    add_theme_support('elementor-full-width');
    add_theme_support('elementor-default-color-palette');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'yiontech-lms'),
        'footer' => __('Footer Menu', 'yiontech-lms'),
        'footer-quick-links' => __('Footer Quick Links Menu', 'yiontech-lms'),
        'footer-company' => __('Footer Company Menu', 'yiontech-lms'),
        'footer-user-portal' => __('Footer User Portal Menu', 'yiontech-lms'),
    ));
    
    // Register sidebar
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'yiontech-lms'),
        'id'            => 'main-sidebar',
        'description'   => __('Add widgets here.', 'yiontech-lms'),
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-6 bg-white p-4 rounded-lg shadow">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title text-xl font-bold mb-3">',
        'after_title'   => '</h2>',
    ));
}
add_action('after_setup_theme', 'yiontech_lms_setup');

// Enqueue scripts and styles
function yiontech_lms_scripts() {
    wp_enqueue_style('yiontech-lms-style', get_stylesheet_uri());
    // Enqueue Tailwind CSS via CDN
    wp_enqueue_style('yiontech-lms-tailwind', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    // Enqueue mobile menu script
    wp_enqueue_script('yiontech-lms-mobile-menu', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'yiontech_lms_scripts');

// Elementor compatibility
function yiontech_lms_elementor_setup() {
    // Add theme compatibility
    add_action('elementor/theme/register_locations', function($elementor_theme_manager) {
        $elementor_theme_manager->register_location('header');
        $elementor_theme_manager->register_location('footer');
    });
}
add_action('after_setup_theme', 'yiontech_lms_elementor_setup');

// Add custom image sizes for courses
add_action('after_setup_theme', 'yiontech_lms_add_image_sizes');
function yiontech_lms_add_image_sizes() {
    add_image_size('course-thumbnail', 400, 250, true);
}

// Full width for Elementor pages
function yiontech_lms_elementor_full_width() {
    if (function_exists('\\Elementor\\Plugin')) {
        $document = \Elementor\Plugin::$instance->documents->get(get_the_ID());
        if ($document && $document->is_built_with_elementor()) {
            ?>
            <style>
                /* Make Elementor pages full width by default */
                body.elementor-page .site-content,
                body.elementor-page .site-content > .container,
                body.elementor-page .site-content > .container > .flex,
                body.elementor-page .site-content > .container > .flex > div:first-child {
                    max-width: 100% !important;
                    width: 100% !important;
                    padding: 0 !important;
                    margin: 0 !important;
                }
                
                /* Align Elementor content with header container */
                body.elementor-page .elementor-section-boxed > .elementor-container {
                    max-width: 1280px;
                    width: 100%;
                    padding-left: 1rem;
                    padding-right: 1rem;
                    margin-left: auto;
                    margin-right: auto;
                }
                
                /* Remove theme container padding for Elementor pages */
                body.elementor-page .container {
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                }
                
                /* Remove theme content padding for Elementor pages */
                body.elementor-page .site-content {
                    padding: 0 !important;
                }
                
                /* Full width sections */
                body.elementor-page .elementor-section-full_width > .elementor-container {
                    max-width: 100% !important;
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                }
                
                /* Responsive adjustments */
                @media (min-width: 640px) {
                    body.elementor-page .elementor-section-boxed > .elementor-container {
                        padding-left: 1.5rem;
                        padding-right: 1.5rem;
                    }
                }
                
                @media (min-width: 1024px) {
                    body.elementor-page .elementor-section-boxed > .elementor-container {
                        padding-left: 2rem;
                        padding-right: 2rem;
                    }
                }
            </style>
            <?php
        }
    }
}
add_action('wp_head', 'yiontech_lms_elementor_full_width');