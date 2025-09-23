<?php get_header(); ?>
<div class="site-content">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-2/3 md:pr-8">
                <h1 class="text-3xl font-bold mb-6">Available Courses</h1>
                
                <?php
                // Check if Tutor LMS is active
                if (function_exists('tutor_utils')) {
                    // Get Tutor LMS courses
                    $courses = tutor_utils()->get_courses([
                        'post_status' => 'publish',
                        'orderby' => 'post_date',
                        'order' => 'DESC'
                    ]);
                    
                    if ($courses->have_posts()) :
                        ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php while ($courses->have_posts()) : $courses->the_post(); ?>
                                <?php get_template_part('template-parts/content', 'course'); ?>
                            <?php endwhile; ?>
                        </div>
                        
                        <div class="mt-8">
                            <?php
                            // Pagination for courses
                            echo paginate_links(array(
                                'total' => $courses->max_num_pages,
                                'prev_text' => __('&laquo; Previous', 'yiontech-lms'),
                                'next_text' => __('Next &raquo;', 'yiontech-lms'),
                                'type' => 'list',
                                'before_page_number' => '<span class="mx-1">',
                                'after_page_number' => '</span>',
                            ));
                            ?>
                        </div>
                        <?php
                        wp_reset_postdata();
                    else :
                        ?>
                        <div class="bg-white rounded-lg shadow-md p-8 text-center">
                            <h2 class="text-2xl font-bold mb-4">No Courses Available</h2>
                            <p>Check back later for new courses.</p>
                        </div>
                        <?php
                    endif;
                } else {
                    // Fallback if Tutor LMS is not active
                    ?>
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Tutor LMS plugin is not active. Please activate it to display courses.
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php
                    // Display regular posts as fallback
                    if (have_posts()) :
                        ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php while (have_posts()) : the_post(); ?>
                                <?php get_template_part('template-parts/content', get_post_format()); ?>
                            <?php endwhile; ?>
                        </div>
                        
                        <div class="mt-8">
                            <?php the_posts_pagination(array(
                                'mid_size' => 2,
                                'prev_text' => __('&laquo; Previous', 'yiontech-lms'),
                                'next_text' => __('Next &raquo;', 'yiontech-lms'),
                            )); ?>
                        </div>
                        <?php
                    else :
                        get_template_part('template-parts/content', 'none');
                    endif;
                }
                ?>
            </div>
            <div class="w-full md:w-1/3 mt-8 md:mt-0">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>