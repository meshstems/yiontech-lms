<?php
/**
 * Tutor LMS redirect to Custom Login 
 */

// Use a more reliable path resolution
 $template_file = locate_template('inc/features/login-modifier/templates/login-blank-template.php');

if ($template_file && file_exists($template_file)) {
    require $template_file;
} else {
    // Fallback to direct path if locate_template fails
    $fallback_path = get_template_directory() . '/inc/features/login-modifier/templates/login-blank-template.php';
    if (file_exists($fallback_path)) {
        require $fallback_path;
    } else {
        echo '<div class="tutor-alert tutor-danger">Register template missing. Please check the file exists at: ' . esc_html($fallback_path) . '</div>';
    }
}