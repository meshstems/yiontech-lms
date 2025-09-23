<div class="bg-white rounded-lg shadow-md p-8 text-center">
    <h2 class="text-2xl font-bold mb-4"><?php _e('Nothing Found', 'yiontech-lms'); ?></h2>
    <?php if (is_home() && current_user_can('publish_posts')) : ?>
        <p class="mb-4"><?php printf(__('Ready to publish your first course? <a href="%s" class="text-blue-600 hover:underline">Get started here</a>.', 'yiontech-lms'), esc_url(admin_url('post-new.php'))); ?></p>
    <?php elseif (is_search()) : ?>
        <p class="mb-4"><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'yiontech-lms'); ?></p>
        <?php get_search_form(); ?>
    <?php else : ?>
        <p class="mb-4"><?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'yiontech-lms'); ?></p>
        <?php get_search_form(); ?>
    <?php endif; ?>
</div>