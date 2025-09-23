<?php
/**
 * Newsletter form template
 *
 * @package Yiontech_LMS
 */
?>
<div class="newsletter-form">
    <form class="mt-4" action="#" method="post">
        <div class="flex flex-col sm:flex-row gap-2">
            <input type="email" name="email" placeholder="Your email address" 
                   class="px-4 py-2 rounded-lg bg-gray-800 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 flex-grow" required>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-300">
                Subscribe
            </button>
        </div>
        <p class="text-xs text-gray-400 mt-2">By subscribing, you agree to our Privacy Policy and consent to receive updates.</p>
    </form>
</div>