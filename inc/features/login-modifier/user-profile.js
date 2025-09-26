(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Export user data
        $('#export-data').on('click', function(e) {
            e.preventDefault();
            
            // Show loading state
            const $message = $('#profile-message');
            $message.html('<div class="loading-message">Processing your request...</div>');
            
            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: yiontech_lms_user_profile.ajax_url,
                data: {
                    action: 'yiontech_lms_export_user_data',
                    nonce: yiontech_lms_user_profile.nonce
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Create a temporary link to download the file
                        const link = document.createElement('a');
                        link.href = 'data:application/json;charset=utf-8,' + encodeURIComponent(JSON.stringify(response.data, null, 2));
                        link.download = 'user-data-' + new Date().toISOString().slice(0, 10) + '.json';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        
                        // Show success message
                        $message.html('<div class="success-message">Your data has been exported successfully.</div>');
                    } else {
                        // Show error message
                        $message.html('<div class="error-message">' + (response.data || 'Failed to export your data. Please try again.') + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    // Show error message
                    $message.html('<div class="error-message">Failed to export your data. Please try again. (' + error + ')</div>');
                }
            });
        });
        
        // Delete user account
        $('#delete-account').on('click', function(e) {
            e.preventDefault();
            
            // Confirm deletion
            if (confirm(yiontech_lms_user_profile.confirm_delete)) {
                // Show loading state
                const $message = $('#profile-message');
                $message.html('<div class="loading-message">Processing your request...</div>');
                
                // Send AJAX request
                $.ajax({
                    type: 'POST',
                    url: yiontech_lms_user_profile.ajax_url,
                    data: {
                        action: 'yiontech_lms_delete_user_account',
                        nonce: yiontech_lms_user_profile.nonce
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            $message.html('<div class="success-message">' + response.data + '</div>');
                            
                            // Redirect to home page after a short delay
                            setTimeout(function() {
                                window.location.href = '<?php echo esc_url(home_url()); ?>';
                            }, 2000);
                        } else {
                            // Show error message
                            $message.html('<div class="error-message">' + (response.data || 'Failed to delete your account. Please try again.') + '</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Show error message
                        $message.html('<div class="error-message">Failed to delete your account. Please try again. (' + error + ')</div>');
                    }
                });
            }
        });
    });
    
})(jQuery);