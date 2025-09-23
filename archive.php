<?php get_header(); ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row">
        <div class="w-full md:w-2/3 md:pr-8">
            <header class="mb-6">
                <h1 class="text-3xl font-bold">
                    <?php
                    if (is_category()) :
                        single_cat_title();
                    elseif (is_tag()) :
                        single_tag_title();
                    elseif (is_author()) :
                        the_post();
                        echo 'Author Archives: ' . get_the_author();
                        rewind_posts();
                    elseif (is_day()) :
                        echo 'Daily Archives: ' . get_the_date();
                    elseif (is_month()) :
                        echo 'Monthly Archives: ' . get_the_date('F Y');
                    elseif (is_year()) :
                        echo 'Yearly Archives: ' . get_the_date('Y');
                    elseif (is_search()) :
                        echo 'Search Results for: ' . get_search_query();
                    else :
                        _e('Archives', 'yiontech-lms');
                    endif;
                    ?>
                </h1>
            </header>
            
            <?php if (have_posts()) : ?>
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
            <?php else : ?>
                <?php get_template_part('template-parts/content', 'none'); ?>
            <?php endif; ?>
        </div>
        <div class="w-full md:w-1/3 mt-8 md:mt-0">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>