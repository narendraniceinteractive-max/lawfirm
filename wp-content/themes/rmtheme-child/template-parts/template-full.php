<?php
/* Template Name: Full Width Page Template
 * @package rmtheme
 */
get_header(); ?>

<?php include( get_stylesheet_directory() . '/partials/page-header.php' ); ?>
<main id="page-content" class="content-area">
    <div class="page-container">
        <div class="page-col-full">
            
            <section id="page-column-full">
                <?php while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>
                    
                <?php endwhile; ?>
            </section>

    	</div>
    </div>
</main>

<?php get_footer();