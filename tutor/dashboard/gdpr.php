<?php
/**
 * Tutor LMS Dashboard – Documents Tab
 */

// Use a more reliable path resolution
 $template_file = locate_template('inc/features/gdpr/template.php');

if ($template_file && file_exists($template_file)) {
    require $template_file;
} else {
    // Fallback to direct path if locate_template fails
    $fallback_path = get_template_directory() . '/inc/features/gdpr/template.php';
    if (file_exists($fallback_path)) {
        require $fallback_path;
    } else {
        echo '<div class="tutor-alert tutor-danger">Documents template missing. Please check the file exists at: ' . esc_html($fallback_path) . '</div>';
    }
}