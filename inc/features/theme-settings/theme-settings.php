<?php
/**
 * Theme Settings Module Loader
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define constants for the module
define('YIONTECH_LMS_THEME_SETTINGS_DIR', get_template_directory() . '/inc/features/theme-settings');
define('YIONTECH_LMS_THEME_SETTINGS_URL', get_template_directory_uri() . '/inc/features/theme-settings');

// Include all necessary files
require_once YIONTECH_LMS_THEME_SETTINGS_DIR . '/admin/general-settings.php';
require_once YIONTECH_LMS_THEME_SETTINGS_DIR . '/admin/header-settings.php';
require_once YIONTECH_LMS_THEME_SETTINGS_DIR . '/admin/footer-settings.php';
require_once YIONTECH_LMS_THEME_SETTINGS_DIR . '/admin/newsletter-settings.php';
require_once YIONTECH_LMS_THEME_SETTINGS_DIR . '/admin/privacy-settings.php';
require_once YIONTECH_LMS_THEME_SETTINGS_DIR . '/admin/css-editor-settings.php';
require_once YIONTECH_LMS_THEME_SETTINGS_DIR . '/admin/field-callbacks.php';
require_once YIONTECH_LMS_THEME_SETTINGS_DIR . '/admin/settings-pages.php';
require_once YIONTECH_LMS_THEME_SETTINGS_DIR . '/admin/display-functions.php';

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