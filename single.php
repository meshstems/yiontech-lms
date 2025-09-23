<?php get_header(); ?>
<?php 
while (have_posts()) : the_post(); 
    // Check if Elementor is being used for this post
    if (function_exists('\\Elementor\\Plugin') && \Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
        // Full width for Elementor pages
        the_content();
    } else {
        // Regular theme layout with container
        ?>
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-2/3 md:pr-8">
                    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-md overflow-hidden mb-8'); ?>>
                        <header class="p-0 border-b">
                            <h1 class="text-3xl font-bold mb-2"><?php the_title(); ?></h1>
                            <div class="text-gray-600">
                                <?php echo get_the_date(); ?> by <?php the_author(); ?>
                            </div>
                        </header>
                        
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('large', array('class' => 'w-full h-64 object-cover')); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="content p-0">
                            <?php the_content(); ?>
                        </div>
                        
                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links mb-4">' . __('Pages:', 'yiontech-lms'),
                            'after'  => '</div>',
                        ));
                        ?>
                        
                        <footer class="p-6 bg-gray-50 border-t">
                            <div class="flex flex-wrap gap-2">
                                <?php the_tags('<span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">', '</span>'); ?>
                            </div>
                        </footer>
                    </article>
                    
                    <?php comments_template(); ?>
                </div>
                <div class="w-full md:w-1/3 mt-8 md:mt-0">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
        <?php
    }
endwhile; 
?>
<?php get_footer(); ?>