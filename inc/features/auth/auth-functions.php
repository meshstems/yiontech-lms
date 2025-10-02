<?php
/**
 * Authentication Functions
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Tutor Dashboard URL
 */
function yiontech_get_tutor_dashboard_url() {
    if (function_exists('tutor_utils')) {
        $dashboard_page_id = (int) tutor_utils()->get_option('tutor_dashboard_page_id');
        $dashboard_slug = $dashboard_page_id ? get_post_field('post_name', $dashboard_page_id) : '';
        if ($dashboard_slug) {
            return home_url(trailingslashit($dashboard_slug));
        }
    }
    return home_url('/');
}
