<?php
/**
 * Newsletter form template
 *
 * @package Yiontech_LMS
 */
?>
<?php
$newsletter_enable = yiontech_lms_get_theme_setting('newsletter_enable');
$newsletter_action_url = yiontech_lms_get_theme_setting('newsletter_action_url');
$newsletter_method = yiontech_lms_get_theme_setting('newsletter_method', 'post');
$newsletter_email_field = yiontech_lms_get_theme_setting('newsletter_email_field', 'email');
$newsletter_hidden_fields = yiontech_lms_get_theme_setting('newsletter_hidden_fields', '');

// Get privacy settings
$enable_privacy_features = yiontech_lms_get_theme_setting('enable_privacy_features');
$privacy_policy_url = yiontech_lms_get_privacy_policy_url();
$terms_of_service_url = yiontech_lms_get_terms_of_service_url();
?>
<?php if ($newsletter_enable && $newsletter_action_url) : ?>
<div class="newsletter-form">
    <form id="newsletter-form" class="mt-4" action="<?php echo esc_url($newsletter_action_url); ?>" method="<?php echo esc_attr($newsletter_method); ?>">
        <?php
        // Add hidden fields
        if (!empty($newsletter_hidden_fields)) {
            $lines = explode("\n", $newsletter_hidden_fields);
            foreach ($lines as $line) {
                $parts = explode('=', $line, 2);
                if (count($parts) == 2) {
                    echo '<input type="hidden" name="' . esc_attr(trim($parts[0])) . '" value="' . esc_attr(trim($parts[1])) . '" />';
                }
            }
        }
        ?>
        <div class="flex flex-col sm:flex-col gap-2">
            <input type="email" name="<?php echo esc_attr($newsletter_email_field); ?>" placeholder="Your email address" 
                   class="px-4 py-2 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 flex-grow" required>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300">
                Subscribe
            </button>
        </div>
        
        <?php if ($enable_privacy_features && ($privacy_policy_url || $terms_of_service_url)) : ?>
            <div class="mt-2 text-xs text-gray-400">
                <input type="checkbox" id="newsletter-privacy-consent" name="privacy_consent" required>
                <label for="newsletter-privacy-consent">
                    <?php 
                    if ($privacy_policy_url && $terms_of_service_url) {
                        echo 'I agree to the <a href="' . esc_url($privacy_policy_url) . '" target="_blank">Privacy Policy</a> and <a href="' . esc_url($terms_of_service_url) . '" target="_blank">Terms of Service</a>';
                    } elseif ($privacy_policy_url) {
                        echo 'I agree to the <a href="' . esc_url($privacy_policy_url) . '" target="_blank">Privacy Policy</a>';
                    } elseif ($terms_of_service_url) {
                        echo 'I agree to the <a href="' . esc_url($terms_of_service_url) . '" target="_blank">Terms of Service</a>';
                    }
                    ?>
                </label>
            </div>
        <?php endif; ?>
        
        <div id="newsletter-message" class="mt-2 text-sm hidden"></div>
        <?php wp_nonce_field('yiontech_lms_newsletter_nonce', 'nonce'); ?>
    </form>
</div>
<?php endif; ?>