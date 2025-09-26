(function($) {
    'use strict';
    
    $(document).ready(function() {
        $('#newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $message = $('#newsletter-message');
            var $submit = $form.find('button[type="submit"]');
            var originalText = $submit.text();
            
            // Show loading state
            $submit.prop('disabled', true).text('Subscribing...');
            $message.removeClass('hidden').removeClass('text-green-600 text-red-600').addClass('text-gray-600').text('Processing...');
            
            // Get form data
            var formData = $form.serialize();
            
            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: yiontech_lms_newsletter.ajax_url,
                data: formData + '&action=yiontech_lms_newsletter',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $message.removeClass('text-gray-600 text-red-600').addClass('text-green-600').text(yiontech_lms_newsletter.success_message);
                        $form[0].reset();
                    } else {
                        $message.removeClass('text-gray-600 text-green-600').addClass('text-red-600').text(response.data);
                    }
                },
                error: function() {
                    $message.removeClass('text-gray-600 text-green-600').addClass('text-red-600').text('Subscription failed. Please try again.');
                },
                complete: function() {
                    $submit.prop('disabled', false).text(originalText);
                }
            });
        });
    });
    
})(jQuery);