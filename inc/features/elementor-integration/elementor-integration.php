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

// Enforce theme settings for Elementor
function yiontech_lms_elementor_theme_settings() {
    // Get theme settings
    $primary_color = yiontech_lms_get_theme_setting('header_background_color', '#1e40af');
    $secondary_color = yiontech_lms_get_theme_setting('footer_background_color', '#111827');
    $text_color = yiontech_lms_get_theme_setting('footer_text_color', '#ffffff');
    $site_width = get_theme_mod('site_width', '1200');
    
    // Apply theme colors to Elementor
    add_filter('elementor/theme/default_color_palette', function($palette) use ($primary_color, $secondary_color) {
        return [
            [
                'title' => __('Primary', 'yiontech-lms'),
                'color' => $primary_color,
            ],
            [
                'title' => __('Secondary', 'yiontech-lms'),
                'color' => $secondary_color,
            ],
            [
                'title' => __('Text', 'yiontech-lms'),
                'color' => $text_color,
            ],
            [
                'title' => __('White', 'yiontech-lms'),
                'color' => '#ffffff',
            ],
            [
                'title' => __('Black', 'yiontech-lms'),
                'color' => '#000000',
            ],
        ];
    });
    
    // Apply theme typography to Elementor
    add_filter('elementor/theme/default_typography', function($typography) {
        $typography['primary_font_family'] = get_theme_mod('primary_font', 'Inter');
        $typography['secondary_font_family'] = get_theme_mod('secondary_font', 'Inter');
        $typography['primary_font_weight'] = get_theme_mod('primary_font_weight', '600');
        $typography['secondary_font_weight'] = get_theme_mod('secondary_font_weight', '400');
        
        return $typography;
    });
    
    // Apply site width to Elementor
    add_filter('elementor/settings/page/settings', function($settings) use ($site_width) {
        $settings['container_width']['default'] = [
            'unit' => 'px',
            'size' => $site_width,
        ];
        $settings['space_between_widgets']['default'] = [
            'unit' => 'px',
            'size' => 20,
        ];
        return $settings;
    });
    
    // Force Elementor to use theme container width
    add_action('elementor/css/after_post', function() {
        $site_width = get_theme_mod('site_width', '1200');
        ?>
        <style>
            .elementor-section.elementor-section-boxed > .elementor-container {
                max-width: <?php echo esc_attr($site_width); ?>px;
                width: 100%;
                margin: 0 auto;
            }
            
            .elementor-section.elementor-section-full_width > .elementor-container {
                max-width: 100%;
                width: 100%;
                padding-left: 15px;
                padding-right: 15px;
            }
            
            @media (max-width: 767px) {
                .elementor-section.elementor-section-boxed > .elementor-container,
                .elementor-section.elementor-section-full_width > .elementor-container {
                    padding-left: 15px;
                    padding-right: 15px;
                }
            }
        </style>
        <?php
    });
}
add_action('wp', 'yiontech_lms_elementor_theme_settings');

// Full width for Elementor pages with Tailwind container width
function yiontech_lms_elementor_full_width() {
    if (function_exists('\\Elementor\\Plugin')) {
        $document = \Elementor\Plugin::$instance->documents->get(get_the_ID());
        if ($document && $document->is_built_with_elementor()) {
            $site_width = get_theme_mod('site_width', '1200');
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
                    max-width: <?php echo esc_attr($site_width); ?>px;
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
                        max-width: <?php echo esc_attr($site_width); ?>px;
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