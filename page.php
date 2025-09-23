<?php get_header(); ?>
<div class="site-content w-full">
    <?php 
    while (have_posts()) : the_post(); 
        if (function_exists('\\Elementor\\Plugin') 
            && \Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
            
            // Elementor-built page → render directly
            the_content();

        } else {
            ?>
            
            <?php if (has_post_thumbnail()) : ?>
                <!-- Full width hero background -->
                <section class="relative w-full">
                    <?php the_post_thumbnail('full', [
                        'class' => 'w-full h-[500px] object-cover'
                    ]); ?>

                    <!-- Content container inside hero -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="max-w-7xl mx-auto px-4 text-center">
                            <h1 class="text-4xl md:text-5xl font-bold text-white drop-shadow-lg">
                                <?php the_title(); ?>
                            </h1>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            
            <!-- Page content -->
            <div class="max-w-7xl mx-auto px-4 py-12">
                <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white shadow-md rounded-lg overflow-hidden'); ?>>
                    
                    <div class="content p-6 prose max-w-none">
                        <?php the_content(); ?>
                    </div>
                </article>
            </div>
            
            <?php
        }
    endwhile; 
    ?>
</div>
<?php get_footer(); ?>
