<?php
/**
 * Document Upload Feature – Functions
 * Secure uploads for Tutor LMS Dashboard with preview & delete
 *
 * @package Yiontech_LMS
 */

if (!defined('ABSPATH')) exit;

define('PRIVATE_UPLOAD_DIR_ROOT', WP_CONTENT_DIR . '/private-user-data/');
define('USER_DOC_META_KEY', 'user_uploaded_documents');

/**
 * Setup private directory with .htaccess protection
 */
add_action('init', function () {
    $root_dir      = PRIVATE_UPLOAD_DIR_ROOT;
    $htaccess_path = $root_dir . '.htaccess';
    $index_path    = $root_dir . 'index.php';

    if (!is_dir($root_dir)) {
        wp_mkdir_p($root_dir);
    }

    // Restrict direct access to uploaded files
    if (!file_exists($htaccess_path)) {
        @file_put_contents($htaccess_path, "Options -Indexes\nDeny from all\n");
    }
    if (!file_exists($index_path)) {
        @file_put_contents($index_path, '<?php // Silence is golden.');
    }
});

/**
 * Add new tab in Tutor Dashboard
 */
add_filter('tutor_dashboard/nav_items', function ($links) {
    $links['document-upload'] = [
        'title' => __('Document Upload', 'tutor'),
        'icon'  => 'tutor-icon-document-upload',
    ];
    return $links;
});

/**
 * Handle file upload & deletion
 */
add_action('init', function () {
    $user_id = get_current_user_id();
    if (!$user_id) return;

    // Upload
    if (isset($_POST['tutor_document_upload_submit'], $_FILES['user_document'])) {
        if (!isset($_POST['tutor_document_upload_nonce']) ||
            !wp_verify_nonce($_POST['tutor_document_upload_nonce'], 'tutor_document_upload_action')) {
            wp_die(__('Security check failed.', 'tutor'));
        }

        $file = $_FILES['user_document'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            wp_redirect(add_query_arg('upload_status', 'file_error', tutor_utils()->tutor_dashboard_url('document-upload')));
            exit;
        }

        // Enhanced file type validation
        $file_name = sanitize_file_name($file['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt');
        
        if (!in_array($file_ext, $allowed_types)) {
            wp_redirect(add_query_arg('upload_status', 'invalid_file_type', tutor_utils()->tutor_dashboard_url('document-upload')));
            exit;
        }

        // File size validation (10MB max)
        $max_size = 10 * 1024 * 1024; // 10MB in bytes
        if ($file['size'] > $max_size) {
            wp_redirect(add_query_arg('upload_status', 'file_too_large', tutor_utils()->tutor_dashboard_url('document-upload')));
            exit;
        }

        $user_dir    = PRIVATE_UPLOAD_DIR_ROOT . $user_id . '/';
        $file_name   = sanitize_file_name($file['name']);
        $target_path = $user_dir . $file_name;

        if (!is_dir($user_dir)) {
            wp_mkdir_p($user_dir);
        }

        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            $existing_files = get_user_meta($user_id, USER_DOC_META_KEY, true);
            if (!is_array($existing_files)) $existing_files = [];

            $new_file_data = [
                'filename'    => $file_name,
                'path'        => $target_path,
                'uploaded_on' => current_time('mysql'),
                'size'        => filesize($target_path),
            ];

            $existing_files[] = $new_file_data;
            update_user_meta($user_id, USER_DOC_META_KEY, $existing_files);

            wp_redirect(add_query_arg('upload_status', 'success', tutor_utils()->tutor_dashboard_url('document-upload')));
            exit;
        }
    }

    // Delete
    if (isset($_POST['tutor_document_delete_submit'], $_POST['delete_filename'])) {
        if (!isset($_POST['tutor_document_delete_nonce']) ||
            !wp_verify_nonce($_POST['tutor_document_delete_nonce'], 'tutor_document_delete_action')) {
            wp_die(__('Security check failed.', 'tutor'));
        }

        $delete_filename = sanitize_text_field($_POST['delete_filename']);
        $existing_files  = get_user_meta($user_id, USER_DOC_META_KEY, true);

        if (is_array($existing_files)) {
            foreach ($existing_files as $key => $file) {
                if ($file['filename'] === $delete_filename) {
                    if (file_exists($file['path'])) @unlink($file['path']);
                    unset($existing_files[$key]);
                }
            }
            update_user_meta($user_id, USER_DOC_META_KEY, array_values($existing_files));
        }

        wp_redirect(add_query_arg('upload_status', 'deleted', tutor_utils()->tutor_dashboard_url('document-upload')));
        exit;
    }
});

/**
 * Secure file serve endpoint for previews/downloads
 */
add_action('init', function () {
    if (isset($_GET['document_download'])) {
        $user_id = get_current_user_id();
        if (!$user_id) {
            wp_die(__('Not authorized', 'tutor'));
        }

        $filename = sanitize_file_name($_GET['document_download']);
        $files    = get_user_meta($user_id, USER_DOC_META_KEY, true);

        if (is_array($files)) {
            foreach ($files as $file) {
                if ($file['filename'] === $filename && file_exists($file['path'])) {
                    $mime = wp_check_filetype($file['filename']);
                    if (empty($mime['type'])) {
                        $mime['type'] = 'application/octet-stream';
                    }
                    header('Content-Type: ' . $mime['type']);
                    header('Content-Disposition: inline; filename="' . basename($file['filename']) . '"');
                    header('Content-Length: ' . filesize($file['path']));
                    readfile($file['path']);
                    exit;
                }
            }
        }

        wp_die(__('File not found or access denied', 'tutor'));
    }
});