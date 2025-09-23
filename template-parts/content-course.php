<?php
/**
 * Template part for displaying course content in the course archive page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Yiontech_LMS
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:shadow-lg hover:-translate-y-1'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="course-thumbnail h-48 overflow-hidden">
            <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
        </div>
    <?php endif; ?>
    
    <div class="p-6">
        <header>
            <h2 class="text-xl font-bold mb-2"><a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800"><?php the_title(); ?></a></h2>
            <div class="flex items-center text-gray-600 text-sm mb-3">
                <?php
                // Display course instructor if Tutor LMS is active
                if (function_exists('tutor_utils')) {
                    $instructor_id = get_post_field('post_author', get_the_ID());
                    ?>
                    <span>by <?php echo get_the_author_meta('display_name', $instructor_id); ?></span>
                    <span class="mx-2">•</span>
                    <?php
                }
                ?>
                <span><?php echo get_the_date(); ?></span>
            </div>
        </header>
        
        <div class="content mb-4">
            <?php the_excerpt(); ?>
        </div>
        
        <div class="flex items-center justify-between mb-4">
            <?php
            // Display course rating if Tutor LMS is active
            if (function_exists('tutor_utils')) {
                $course_rating = tutor_utils()->get_course_rating();
                if ($course_rating->rating_count > 0) {
                    ?>
                    <div class="flex items-center">
                        <div class="flex text-yellow-400">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <?php if ($i <= round($course_rating->rating_avg)) : ?>
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                <?php else : ?>
                                    <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <span class="text-sm text-gray-600 ml-1">(<?php echo $course_rating->rating_count; ?>)</span>
                    </div>
                    <?php
                }
            }
            ?>
            
            <?php
            // Display course price if Tutor LMS is active
            if (function_exists('tutor_utils')) {
                $price = tutor_utils()->get_course_price();
                if ($price) {
                    ?>
                    <div class="text-lg font-bold text-blue-600">
                        <?php echo $price; ?>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        
        <footer>
            <a href="<?php the_permalink(); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition duration-300">View Course</a>
        </footer>
    </div>
</article>