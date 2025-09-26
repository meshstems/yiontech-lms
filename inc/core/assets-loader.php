<?php
/**
 * Assets Loader
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue scripts and styles
function yiontech_lms_scripts() {
    // Get theme version for cache busting
    $theme_version = wp_get_theme()->get('Version');
    
    wp_enqueue_style('yiontech-lms-style', get_stylesheet_uri(), array(), $theme_version);
    // Enqueue Tailwind CSS via CDN
    wp_enqueue_style('yiontech-lms-tailwind', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', array(), $theme_version);
    
    // Enqueue jQuery if it's not already loaded
    wp_enqueue_script('jquery');
    
    // Enqueue mobile menu script
    wp_enqueue_script('yiontech-lms-mobile-menu', get_template_directory_uri() . '/js/script.js', array('jquery'), $theme_version, true);
    
    // Enqueue admin styles
    if (is_admin()) {
        wp_enqueue_style('yiontech-lms-admin', get_template_directory_uri() . '/css/admin.css', array(), $theme_version);
        wp_enqueue_script('yiontech-lms-admin', get_template_directory_uri() . '/js/admin.js', array('jquery', 'wp-color-picker'), $theme_version, true);
    }
    
    // Add inline script to prevent scroll jumps
    wp_add_inline_script('jquery', '
        jQuery(document).ready(function($) {
            // Store scroll position before any scripts run
            var scrollPosition = $(window).scrollTop();
            
            // Restore scroll position after all scripts are initialized
            $(window).on("load", function() {
                setTimeout(function() {
                    $(window).scrollTop(scrollPosition);
                }, 100);
            });
        });
    ');
}
add_action('wp_enqueue_scripts', 'yiontech_lms_scripts');