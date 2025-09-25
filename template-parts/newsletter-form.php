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
        <div class="flex flex-col sm:flex-row gap-2">
            <input type="email" name="<?php echo esc_attr($newsletter_email_field); ?>" placeholder="Your email address" 
                   class="px-4 py-2 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 flex-grow" required>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300">
                Subscribe
            </button>
        </div>
        <div id="newsletter-message" class="mt-2 text-sm hidden"></div>
        <p class="text-xs text-gray-400 mt-2">By subscribing, you agree to our Privacy Policy and consent to receive updates.</p>
        <?php wp_nonce_field('yiontech_lms_newsletter_nonce', 'nonce'); ?>
    </form>
</div>
<?php endif; ?>