<?php get_header(); ?>
<div class="container mx-auto px-4 py-16">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-8 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">404 - Page Not Found</h1>
        <p class="text-gray-600 mb-6">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded">Go to Homepage</a>
    </div>
</div>
<?php get_footer(); ?>