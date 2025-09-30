<?php
/**
 * Optimized Assets Loader
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles
function yiontech_lms_scripts() {
    $theme_version = wp_get_theme()->get('Version');
    
    // Main styles
    wp_enqueue_style('yiontech-lms-style', get_stylesheet_uri(), array(), $theme_version);
    
    // Only load Tailwind if not using Elementor
    if (!function_exists('\\Elementor\\Plugin') || !\Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
        wp_enqueue_style('yiontech-lms-tailwind', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', array(), $theme_version);
    }
    
    // jQuery with defer
    wp_enqueue_script('jquery');
    wp_script_add_data('jquery', 'defer', true);
    
    // Main combined script (always needed)
    wp_enqueue_script('yiontech-lms-main', get_template_directory_uri() . '/js/main.js', array('jquery'), $theme_version, true);
    wp_script_add_data('yiontech-lms-main', 'defer', true);
    
    // Conditional scripts
    $enable_preloader = yiontech_lms_get_theme_setting('enable_preloader');
    if ($enable_preloader && (!function_exists('\\Elementor\\Plugin') || !\Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor())) {
        wp_enqueue_script('yiontech-lms-preloader', get_template_directory_uri() . '/js/preloader.js', array('jquery'), $theme_version, true);
        wp_script_add_data('yiontech-lms-preloader', 'defer', true);
    }
    
    // User-related scripts (only on frontend)
    if (!is_admin()) {
        wp_enqueue_script('yiontech-lms-user-main', get_template_directory_uri() . '/js/user-main.js', array('jquery'), $theme_version, true);
        wp_script_add_data('yiontech-lms-user-main', 'defer', true);
    }
    
    // Admin scripts
    if (is_admin()) {
        wp_enqueue_style('yiontech-lms-admin', get_template_directory_uri() . '/css/admin.css', array(), $theme_version);
        wp_enqueue_script('yiontech-lms-admin', get_template_directory_uri() . '/js/admin.js', array('jquery', 'wp-color-picker'), $theme_version, true);
    }
}
add_action('wp_enqueue_scripts', 'yiontech_lms_scripts');