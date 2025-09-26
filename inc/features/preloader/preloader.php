<?php
/**
 * Preloader Feature
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Enqueue preloader script if enabled
function yiontech_lms_enqueue_preloader_script() {
    $enable_preloader = yiontech_lms_get_theme_setting('enable_preloader');
    if ($enable_preloader) {
        $theme_version = wp_get_theme()->get('Version');
        wp_enqueue_script('yiontech-lms-preloader', get_template_directory_uri() . '/inc/features/preloader/preloader.js', array('jquery'), $theme_version, true);
    }
}
add_action('wp_enqueue_scripts', 'yiontech_lms_enqueue_preloader_script');

// Add preloader to header
function yiontech_lms_add_preloader() {
    $enable_preloader = yiontech_lms_get_theme_setting('enable_preloader');
    if ($enable_preloader) {
        ?>
        <div id="preloader">
            <div class="preloader-spinner">
                <div class="spinner"></div>
            </div>
        </div>
        <?php
    }
}
add_action('wp_body_open', 'yiontech_lms_add_preloader');