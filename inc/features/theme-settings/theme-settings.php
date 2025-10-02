<?php
/**
 * Theme Settings Module Loader
 *
 * @package Yiontech_LMS
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define constants for the module
define('YIONTECH_LMS_THEME_SETTINGS_DIR', get_template_directory() . '/inc/features/theme-settings');
define('YIONTECH_LMS_THEME_SETTINGS_URL', get_template_directory_uri() . '/inc/features/theme-settings');

// Autoloader for admin files
function yiontech_lms_theme_settings_autoloader() {
    $admin_dir = YIONTECH_LMS_THEME_SETTINGS_DIR . '/admin/';
    
    // Get all PHP files in the admin directory
    $files = glob($admin_dir . '*.php');
    
    if ($files) {
        foreach ($files as $file) {
            require_once $file;
        }
    }
}

// Run the autoloader
yiontech_lms_theme_settings_autoloader();

// Initialize the module
function yiontech_lms_theme_settings_init() {
    // Register settings, sections, and fields
    add_action('admin_init', 'yiontech_lms_theme_settings_admin_init');
    
    // Add theme settings page to admin menu
    add_action('admin_menu', 'yiontech_lms_add_theme_settings_page');
    
    // Enqueue admin scripts and styles
    add_action('admin_enqueue_scripts', 'yiontech_lms_admin_enqueue_scripts');
    
    // Output custom CSS
    add_action('wp_head', 'yiontech_lms_output_custom_css', 100);
    
    // Gutenberg support
    add_action('after_setup_theme', 'yiontech_lms_gutenberg_support');
    
    // Customizer integration
    add_action('customize_register', 'yiontech_lms_customize_register');
}
add_action('after_setup_theme', 'yiontech_lms_theme_settings_init');