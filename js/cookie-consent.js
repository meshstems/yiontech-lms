(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Check if cookie consent banner exists
        const $cookieBanner = $('#cookie-consent-banner');
        
        if ($cookieBanner.length) {
            // Check if user has already consented
            if (document.cookie.indexOf('yiontech_lms_cookie_consent=accepted') > -1) {
                $cookieBanner.hide();
            }
            
            // Cookie consent accept button
            $('#cookie-consent-accept').on('click', function(e) {
                e.preventDefault();
                
                // Send AJAX request
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
                            // Hide cookie consent banner
                            $cookieBanner.fadeOut();
                            
                            // Set cookie for 1 year
                            var date = new Date();
                            date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
                            var expires = "expires=" + date.toUTCString();
                            document.cookie = "yiontech_lms_cookie_consent=accepted;" + expires + ";path=/";
                        }
                    },
                    error: function() {
                        console.log('Cookie consent failed');
                        // Fallback - set cookie anyway
                        var date = new Date();
                        date.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
                        var expires = "expires=" + date.toUTCString();
                        document.cookie = "yiontech_lms_cookie_consent=accepted;" + expires + ";path=/";
                        $cookieBanner.fadeOut();
                    }
                });
            });
        }
    });
    
})(jQuery);