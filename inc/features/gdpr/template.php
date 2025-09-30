<?php
if (!defined('ABSPATH')) exit;

$user_id = get_current_user_id();
$user = wp_get_current_user();

if (!$user_id) {
    echo '<p>' . __('You must be logged in to access this page.', 'tutor') . '</p>';
    return;
}

$is_admin = in_array('administrator', $user->roles);
?>

<div class="tutor-dashboard-content-inner">
    <h4><?php esc_html_e('GDPR Compliance – Your Data', 'tutor'); ?></h4>
    <p><?php esc_html_e('Export your personal data and delete your account if allowed.', 'tutor'); ?></p>

    <!-- Export Data -->
    <button type="button" id="export-data-btn" class="tutor-btn tutor-btn-primary tutor-mb-20">
        <i class="tutor-icon-download"></i> <?php esc_html_e('Export My Data', 'tutor'); ?>
    </button>

    <!-- Delete Account -->
    <?php if (!$is_admin): ?>
    <button type="button" id="delete-account-btn" class="tutor-btn tutor-btn-danger">
        <i class="tutor-icon-trash"></i> <?php esc_html_e('Delete My Account', 'tutor'); ?>
    </button>
    <?php endif; ?>

    <div id="gdpr-status" class="tutor-mt-20"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // Export Data
    document.getElementById('export-data-btn').addEventListener('click', function() {
        window.location.href = "<?php echo admin_url('admin-ajax.php?action=gdpr_export_zip'); ?>";
    });

    // Delete Account
    <?php if (!$is_admin): ?>
    document.getElementById('delete-account-btn').addEventListener('click', function() {
        if(!confirm("<?php echo esc_js('Are you sure you want to delete your account? This cannot be undone.'); ?>")) return;

        const statusDiv = document.getElementById('gdpr-status');
        statusDiv.textContent = '<?php echo esc_js("Deleting account..."); ?>';

        fetch("<?php echo admin_url('admin-ajax.php'); ?>?action=delete_user_account", {
            method: "POST",
            credentials: "same-origin"
        }).then(res => res.json())
        .then(data => {
            if(data.success){
                alert("<?php echo esc_js('Your account has been deleted successfully.'); ?>");
                window.location.href = "<?php echo home_url(); ?>";
            } else {
                statusDiv.innerHTML = '<div class="tutor-alert tutor-danger">' + data.data.message + '</div>';
            }
        });
    });
    <?php endif; ?>

});
</script>
