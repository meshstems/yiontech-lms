// Combined user-related scripts
(function($) {
    'use strict';

    // 1. Newsletter Functionality
    function initNewsletter() {
        const $form = $('#newsletter-form');
        if (!$form.length) return;

        $form.on('submit', function(e) {
            e.preventDefault();
            
            const $submit = $form.find('button[type="submit"]');
            const $message = $('#newsletter-message');
            const originalText = $submit.text();
            
            $submit.prop('disabled', true).text('Subscribing...');
            $message.removeClass('hidden').text('Processing...');

            $.ajax({
                type: 'POST',
                url: yiontech_lms_newsletter.ajax_url,
                data: $form.serialize() + '&action=yiontech_lms_newsletter',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $message.addClass('text-green-600').text(yiontech_lms_newsletter.success_message);
                        $form[0].reset();
                    } else {
                        $message.addClass('text-red-600').text(response.data);
                    }
                },
                error: function() {
                    $message.addClass('text-red-600').text('Subscription failed. Please try again.');
                },
                complete: function() {
                    $submit.prop('disabled', false).text(originalText);
                }
            });
        });
    }

    // 2. Cookie Consent Functionality
    function initCookieConsent() {
        const $banner = $('#cookie-consent-banner');
        if (!$banner.length) return;

        if (document.cookie.indexOf('yiontech_lms_cookie_consent=accepted') > -1) {
            $banner.hide();
            return;
        }

        $('#cookie-consent-accept').on('click', function(e) {
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: yiontech_lms_cookie_consent.ajax_url,
                data: {
                    action: 'yiontech_lms_cookie_consent',
                    nonce: yiontech_lms_cookie_consent.nonce
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $banner.fadeOut();
                        const date = new Date();
                        date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
                        document.cookie = "yiontech_lms_cookie_consent=accepted;" + date.toUTCString() + ";path=/";
                    }
                },
                error: function() {
                    $banner.fadeOut();
                    document.cookie = "yiontech_lms_cookie_consent=accepted;" + date.toUTCString() + ";path=/";
                }
            });
        });
    }

   

})(jQuery);