<?php
/**
 * Elementor Integration Feature
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Elementor compatibility
function yiontech_lms_elementor_setup() {
    // Add theme compatibility
    if (function_exists('elementor_theme_do_location')) {
        add_action('elementor/theme/register_locations', function($elementor_theme_manager) {
            $elementor_theme_manager->register_location('header');
            $elementor_theme_manager->register_location('footer');
        });
    }
}
add_action('after_setup_theme', 'yiontech_lms_elementor_setup');

// Full width for Elementor pages with Tailwind container width
function yiontech_lms_elementor_full_width() {
    if (function_exists('\\Elementor\\Plugin')) {
        $document = \Elementor\Plugin::$instance->documents->get(get_the_ID());
        if ($document && $document->is_built_with_elementor()) {
            ?>
            <style>
                /* Only remove theme container constraints for Elementor pages */
                body.elementor-page .site-content > .container,
                body.elementor-page .site-content > .container > .flex,
                body.elementor-page .site-content > .container > .flex > div:first-child {
                    max-width: 100% !important;
                    width: 100% !important;
                    padding: 0 !important;
                    margin: 0 !important;
                }
                
                /* But preserve Elementor's own container settings */
                body.elementor-page .elementor-section.elementor-section-boxed > .elementor-container {
                    max-width: 1140px;
                    width: 100%;
                    padding-left: 15px;
                    padding-right: 15px;
                    margin-left: auto;
                    margin-right: auto;
                }
                
                /* Full width sections should remain full width */
                body.elementor-page .elementor-section.elementor-section-full_width > .elementor-container {
                    max-width: 100% !important;
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                }
                
                /* Responsive adjustments */
                @media (min-width: 768px) {
                    body.elementor-page .elementor-section.elementor-section-boxed > .elementor-container {
                        max-width: 720px;
                    }
                }
                
                @media (min-width: 992px) {
                    body.elementor-page .elementor-section.elementor-section-boxed > .elementor-container {
                        max-width: 960px;
                    }
                }
                
                @media (min-width: 1200px) {
                    body.elementor-page .elementor-section.elementor-section-boxed > .elementor-container {
                        max-width: 1140px;
                    }
                }
            </style>
            <?php
        }
    }
}
add_action('wp_head', 'yiontech_lms_elementor_full_width');

// Add proper Elementor initialization
add_action('wp', function() {
    if (class_exists('\\Elementor\\Plugin')) {
        $elementor = \Elementor\Plugin::instance();
        
        // Make sure Elementor frontend is initialized
        if (method_exists($elementor, 'frontend')) {
            $elementor->frontend->init();
        }
    }
}, 20); // Priority 20 to run after most initializations

