<?php
if (!defined('ABSPATH')) exit;

// Add GDPR tab to Tutor dashboard
add_filter('tutor_dashboard/nav_items', function ($links) {
    $links['gdpr'] = [
        'title' => __('GDPR Compliance', 'tutor'),
        'icon'  => 'tutor-icon-shield',
    ];
    return $links;
});

// AJAX: Delete user account (non-admin only)
add_action('wp_ajax_delete_user_account', function () {
    if (!is_user_logged_in()) wp_send_json_error(['message' => 'User not logged in']);

    $user_id = get_current_user_id();
    $user = wp_get_current_user();

    if (in_array('administrator', $user->roles)) {
        wp_send_json_error(['message' => 'Administrators cannot delete their accounts.']);
    }

    require_once(ABSPATH . 'wp-admin/includes/user.php');
    $deleted = wp_delete_user($user_id);

    if ($deleted) {
        wp_logout();
        wp_send_json_success(['message' => 'Your account has been deleted successfully.']);
    } else {
        wp_send_json_error(['message' => 'Failed to delete account. Please try again later.']);
    }
});

// AJAX: Export GDPR data as ZIP
add_action('wp_ajax_gdpr_export_zip', function () {
    if (!is_user_logged_in()) wp_send_json_error(['message' => 'User not logged in']);

    $user_id = get_current_user_id();
    $user = wp_get_current_user();

    // Basic user info
    $personal_data = [
        'ID' => $user->ID,
        'username' => $user->user_login,
        'email' => $user->user_email,
        'registered' => $user->user_registered,
        'first_name' => $user->first_name,
        'last_name' => $user->last_name,
        'roles' => $user->roles,
        'phone_number' => get_user_meta($user_id, 'phone_number', true),
        'bio' => get_user_meta($user_id, '_tutor_profile_bio', true),
        'registration_number' => get_user_meta($user_id, 'yiontech_registration_number', true),
    ];

    // Uploaded documents
    $uploaded_docs = get_user_meta($user_id, 'user_uploaded_documents', true);
    $files_to_include = [];
    $personal_data['uploaded_documents'] = [];

    if (is_array($uploaded_docs)) {
        foreach ($uploaded_docs as $doc) {
            $filename = $doc['filename'] ?? '';
            $path = $doc['path'] ?? '';
            if ($filename && file_exists($path)) {
                $files_to_include[] = $path;
                $personal_data['uploaded_documents'][] = [
                    'filename' => $filename,
                    'uploaded_on' => $doc['uploaded_on'] ?? '',
                    'size' => $doc['size'] ?? '',
                ];
            }
        }
    }

    // Tutor LMS courses, lessons, quizzes, certificates
    $personal_data['enrolled_courses'] = tutor_utils()->get_user_enrolled_courses($user_id) ?: [];
    $personal_data['completed_lessons'] = tutor_utils()->get_user_completed_lessons($user_id) ?: [];
    $personal_data['completed_quizzes'] = tutor_utils()->get_user_quiz_results($user_id) ?: [];
    $personal_data['certificates'] = get_user_meta($user_id, '_tutor_certificates', true) ?: [];

    // Create temporary files
    $upload_dir = wp_upload_dir();
    $tmp_dir = $upload_dir['basedir'] . '/gdpr_exports/';
    if (!is_dir($tmp_dir)) wp_mkdir_p($tmp_dir);

    $json_file = $tmp_dir . "user_{$user_id}_data.json";
    file_put_contents($json_file, json_encode($personal_data, JSON_PRETTY_PRINT));

    // Create ZIP
    $zip_file = $tmp_dir . "user_{$user_id}_data.zip";
    $zip = new ZipArchive();
    if ($zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        wp_send_json_error(['message' => 'Failed to create ZIP']);
    }

    $zip->addFile($json_file, basename($json_file));
    foreach ($files_to_include as $file) {
        $zip->addFile($file, 'uploads/' . basename($file));
    }
    $zip->close();

    // Serve ZIP
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="user_data.zip"');
    header('Content-Length: ' . filesize($zip_file));
    readfile($zip_file);

    @unlink($json_file);
    @unlink($zip_file);
    exit;
});
