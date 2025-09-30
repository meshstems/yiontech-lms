<?php
/**
 * Document Upload Feature – Template (Image Thumbnail + File Type Icons)
 *
 * @package Yiontech_LMS
 */
if (!defined('ABSPATH')) exit;

$user_id        = get_current_user_id();
$uploaded_files = get_user_meta($user_id, USER_DOC_META_KEY, true);
if (!is_array($uploaded_files)) $uploaded_files = [];
?>

<div class="tutor-dashboard-content-inner">
    <h4><?php esc_html_e('My Documents', 'tutor'); ?></h4>

    <!-- Upload form -->
    <form method="post" enctype="multipart/form-data" class="tutor-mb-20 tutor-flex tutor-items-center tutor-gap-3 mt-10 flex flex-row justify-between">
        <?php wp_nonce_field('tutor_document_upload_action', 'tutor_document_upload_nonce'); ?>

        <!-- Custom Upload -->
        <div class="custom-upload-wrapper tutor-flex tutor-items-center tutor-gap-2">
            <input type="file" id="user_document" name="user_document" required>
            <label for="user_document" class="tutor-btn tutor-btn-primary tutor-btn-icon">
                <i class="tutor-icon-upload"></i> <?php esc_html_e('Choose File', 'tutor'); ?>
            </label>
            <span id="file-chosen" class="tutor-color-muted">
                <?php esc_html_e('No file chosen', 'tutor'); ?>
            </span>
        </div>

        <button type="submit" name="tutor_document_upload_submit" class="tutor-btn tutor-btn-success gap-1">
            <i class="tutor-icon-plus"></i> <?php esc_html_e('Upload', 'tutor'); ?>
        </button>
    </form>

    <?php if (!empty($uploaded_files)) : ?>
        <div class="tutor-table-responsive">
            <table class="tutor-table tutor-table-bordered tutor-mt-20">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Preview', 'tutor'); ?></th>
                        <th><?php esc_html_e('Filename', 'tutor'); ?></th>
                        <th><?php esc_html_e('File Type', 'tutor'); ?></th>
                        <th><?php esc_html_e('Size', 'tutor'); ?></th>
                        <th><?php esc_html_e('Date Uploaded', 'tutor'); ?></th>
                        <th><?php esc_html_e('Action', 'tutor'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($uploaded_files as $file) :
                        $filetype = strtolower(pathinfo($file['filename'], PATHINFO_EXTENSION));
                        $file_url = add_query_arg('document_download', urlencode($file['filename']), site_url());
                        ?>
                        <tr>
                            <td>
                                <a href="<?php echo esc_url($file_url); ?>" target="_blank">
                                    <?php if (in_array($filetype, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) : ?>
                                        <!-- Show real image thumbnail -->
                                        <img src="<?php echo esc_url($file_url); ?>" style="width:40px;height:40px;object-fit:cover;border-radius:4px;">

                                    <?php elseif ($filetype === 'pdf') : ?>
                                        <!-- PDF SVG -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" style="width:24px;height:24px;color:#e63946;" fill="currentColor" viewBox="0 0 384 512">
                                            <path d="M181.9 256.1c-4.8 0-8.9-3.3-9.8-7.9L128 32h128l-44.1 216.2c-.9 4.6-5 7.9-9.8 7.9zm202.6-98.7l-84.9-84.9c-9.1-9.1-21.6-14.2-34.6-14.2H48C21.5 58.3 0 79.8 0 106.3v299.4c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V173.8c0-13-5.1-25.5-14.5-35.9z"/>
                                        </svg>

                                    <?php elseif (in_array($filetype, ['doc', 'docx'])) : ?>
                                        <!-- Word SVG -->
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#2b579a;" fill="currentColor" viewBox="0 0 384 512">
                                            <path d="M64 32H320c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H64c-17.7 0-32-14.3-32-32V64C32 46.3 46.3 32 64 32zM96 128V384H128V128H96zM160 128V384H192V128H160zM224 128V384h32V128H224z"/>
                                        </svg>

                                    <?php elseif (in_array($filetype, ['xls', 'xlsx'])) : ?>
                                        <!-- Excel SVG -->
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#217346;" fill="currentColor" viewBox="0 0 384 512">
                                            <path d="M64 32H320c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H64c-17.7 0-32-14.3-32-32V64C32 46.3 46.3 32 64 32zM256 128L192 256 256 384H224L160 256l64-128h32z"/>
                                        </svg>

                                    <?php elseif (in_array($filetype, ['ppt', 'pptx'])) : ?>
                                        <!-- PowerPoint SVG -->
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#d24726;" fill="currentColor" viewBox="0 0 384 512">
                                            <path d="M192 32H64C46.3 32 32 46.3 32 64V448c0 17.7 14.3 32 32 32H192V32zM256 32V480h64c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32H256z"/>
                                        </svg>

                                    <?php elseif ($filetype === 'txt') : ?>
                                        <!-- Text file SVG -->
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#444;" fill="currentColor" viewBox="0 0 384 512">
                                            <path d="M64 32H320c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H64c-17.7 0-32-14.3-32-32V64C32 46.3 46.3 32 64 32zM96 128H288v32H96V128zM96 192H288v32H96V192zM96 256H224v32H96V256z"/>
                                        </svg>

                                    <?php else : ?>
                                        <!-- Generic file SVG -->
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width:24px;height:24px;color:#888;" fill="currentColor" viewBox="0 0 384 512">
                                            <path d="M224 136V0H64C46.3 0 32 14.3 32 32V480c0 17.7 14.3 32 32 32H320c17.7 0 32-14.3 32-32V160H248C234.7 160 224 149.3 224 136zM384 121.9V128H256V0h6.1c8.5 0 16.6 3.4 22.6 9.4L374.6 97.4c6 6 9.4 14.1 9.4 22.6z"/>
                                        </svg>
                                    <?php endif; ?>
                                </a>
                            </td>
                            <td><?php echo esc_html($file['filename']); ?></td>
                            <td><?php echo strtoupper(esc_html($filetype)); ?></td>
                            <td><?php echo isset($file['size']) ? size_format($file['size']) : __('N/A', 'tutor'); ?></td>
                            <td><?php echo esc_html(date(get_option('date_format'), strtotime($file['uploaded_on']))); ?></td>
                            <td>
                                <form method="post" onsubmit="return confirm('Are you sure you want to remove this file?');">
                                    <?php wp_nonce_field('tutor_document_delete_action', 'tutor_document_delete_nonce'); ?>
                                    <input type="hidden" name="delete_filename" value="<?php echo esc_attr($file['filename']); ?>">
                                    <button type="submit" name="tutor_document_delete_submit" class="tutor-btn tutor-btn-sm tutor-btn-danger">
                                        <i class="tutor-icon-trash"></i> <?php esc_html_e('Remove', 'tutor'); ?>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p class="tutor-text-muted tutor-mt-20"><?php esc_html_e('No documents uploaded yet.', 'tutor'); ?></p>
    <?php endif; ?>
</div>

<!-- Styles to hide native file input -->
<style>
    #user_document {
        position: absolute;
        left: -9999px;
        visibility: hidden;
        width: 0;
        height: 0;
    }
</style>

<!-- JavaScript to Show File Name -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const fileInput = document.getElementById("user_document");
    const fileChosen = document.getElementById("file-chosen");

    fileInput.addEventListener("change", function() {
        fileChosen.textContent = this.files.length > 0 ? this.files[0].name : "<?php esc_html_e('No file chosen', 'tutor'); ?>";
    });
});
</script>
