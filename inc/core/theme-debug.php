<?php
/**
 * Theme Debug Functions
 *
 * @package Yiontech_LMS
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Show template with path for debugging
 */
function yiontech_lms_show_template_with_path() {
    if (current_user_can('manage_options')) {
        global $template;
        echo '<div style="position:fixed;bottom:0;left:0;width:100%;background:#fff;padding:10px;border-top:2px solid #000;z-index:9999;font-size:14px;font-family:monospace">';
        echo 'Template used: <strong>' . $template . '</strong>';
        echo '</div>';
    }
}
add_action('wp_footer', 'yiontech_lms_show_template_with_path');