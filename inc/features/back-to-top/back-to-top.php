<?php
/**
 * Back to Top Feature
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue back-to-top script if enabled
function yiontech_lms_enqueue_back_to_top_script() {
    $enable_back_to_top = yiontech_lms_get_theme_setting('enable_back_to_top');
    if ($enable_back_to_top) {
        $theme_version = wp_get_theme()->get('Version');
        wp_enqueue_script('yiontech-lms-back-to-top', get_template_directory_uri() . '/inc/features/back-to-top/back-to-top.js', array('jquery'), $theme_version, true);
    }
}
add_action('wp_enqueue_scripts', 'yiontech_lms_enqueue_back_to_top_script');

// Add back-to-top button to footer
function yiontech_lms_add_back_to_top_button() {
    $enable_back_to_top = yiontech_lms_get_theme_setting('enable_back_to_top');
    if ($enable_back_to_top) {
        ?>
        <a href="#" id="back-to-top" class="back-to-top">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
            </svg>
        </a>
        <?php
    }
}
add_action('wp_footer', 'yiontech_lms_add_back_to_top_button');