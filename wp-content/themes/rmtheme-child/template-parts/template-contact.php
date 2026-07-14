<?php
/* Template Name: Contact Page Template
 * @package rmtheme
 */
get_header(); ?>
<?php include( get_stylesheet_directory() . '/partials/page-header.php' ); ?>
<main id="page-content" class="content-area">
    <div class="page-container">
        <div class="contact-page">
            <section id="contact-main" class="full-width">
                <?php while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>
                    
                <?php endwhile; ?>
            </section>

    	</div>
    </div>
</main>

<?php get_footer();