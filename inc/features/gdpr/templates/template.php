<?php
if (!defined('ABSPATH')) exit;

 $user_id = get_current_user_id();
 $user = wp_get_current_user();
if (!$user_id) {
    echo '<p>' . __('You must be logged in to access this page.', 'tutor') . '</p>';
    return;
}
?>
<style>
.tutor-dashboard-menu-item.tutor-gdpr-tab .tutor-dashboard-menu-item-icon::before {
    content: '';
    display: inline-block;
    width: 20px;
    height: 20px;
    margin-right: 8px;
    vertical-align: middle;
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-6h2v6zm0-8h-2V7h2v4z"/></svg>');
    background-size: contain;
    background-repeat: no-repeat;
}
</style>
<div class="tutor-dashboard-content-inner">
    <h4><?php esc_html_e('GDPR Compliance – Your Data', 'tutor'); ?></h4>
    <p><?php esc_html_e('Export your personal data and delete your account if allowed.', 'tutor'); ?></p>

    <!-- Export Data -->
    <button type="button" id="export-data-btn" class="tutor-btn tutor-btn-primary tutor-mb-20">
        <i class="tutor-icon-download"></i> <?php esc_html_e('Export My Data', 'tutor'); ?>
    </button>

    <!-- Delete Account -->
    <button type="button" id="delete-account-btn" class="tutor-btn tutor-btn-danger">
        <i class="tutor-icon-trash"></i> <?php esc_html_e('Delete My Account', 'tutor'); ?>
    </button>

    <div id="gdpr-status" class="tutor-mt-20"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Export Data
    document.getElementById('export-data-btn').addEventListener('click', function() {
        window.location.href = "<?php echo admin_url('admin-ajax.php?action=gdpr_export_zip'); ?>";
    });

    // Delete Account
    document.getElementById('delete-account-btn').addEventListener('click', function() {
        if(!confirm("<?php echo esc_js('Are you sure you want to delete your account? This cannot be undone.'); ?>")) return;

        const statusDiv = document.getElementById('gdpr-status');
        statusDiv.innerHTML = '<?php echo esc_js("Deleting account..."); ?>';

        fetch("<?php echo admin_url('admin-ajax.php?action=delete_user_account'); ?>", {
            method: "POST",
            credentials: "same-origin",
            headers: {
                'X-WP-Nonce': "<?php echo wp_create_nonce('wp_rest'); ?>"
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                alert(data.data.message);
                window.location.href = "<?php echo home_url(); ?>";
            } else {
                statusDiv.innerHTML = '<div class="tutor-alert tutor-danger">' + data.data.message + '</div>';
            }
        }).catch(err => {
            statusDiv.innerHTML = '<div class="tutor-alert tutor-danger">An error occurred.</div>';
        });
    });
});
</script>