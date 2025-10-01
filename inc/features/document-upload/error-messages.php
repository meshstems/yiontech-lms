<?php
/**
 * Document Upload Error Messages
 *
 * @package Yiontech_LMS
 */

// Add custom error messages for document upload status
add_action('tutor_dashboard/before_content', function() {
    if (isset($_GET['upload_status'])) {
        $status = sanitize_text_field($_GET['upload_status']);
        $message = '';
        $type = 'success';
        
        switch ($status) {
            case 'success':
                $message = __('Document uploaded successfully!', 'tutor');
                $type = 'success';
                break;
            case 'deleted':
                $message = __('Document deleted successfully!', 'tutor');
                $type = 'success';
                break;
            case 'file_error':
                $message = __('Error uploading file. Please try again.', 'tutor');
                $type = 'danger';
                break;
            case 'invalid_file_type':
                $message = __('Invalid file type. Allowed types: JPG, JPEG, PNG, GIF, PDF, DOC, DOCX, TXT', 'tutor');
                $type = 'danger';
                break;
            case 'file_too_large':
                $message = __('File size too large. Maximum size: 10MB', 'tutor');
                $type = 'danger';
                break;
            default:
                $message = __('An unknown error occurred.', 'tutor');
                $type = 'danger';
                break;
        }
        
        if ($message) {
            echo '<div class="tutor-alert tutor-' . esc_attr($type) . '">' . esc_html($message) . '</div>';
        }
    }
});