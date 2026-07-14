<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package rmtheme
 */
get_header();
?>
<?php include( get_stylesheet_directory() . '/partials/page-header.php' ); ?>
<main id="post-content" class="content-area">
    <div class="post-container">
        <div class="post-col-full">

            <?php get_sidebar('blog'); ?>

            <section id="post-column-full">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        get_template_part('template-parts/template', 'posts');
                    endwhile;
                    echo '<div class="post-pagination">';
                    the_posts_pagination(
                            array(
                                'mid_size' => 2,
                                'prev_text' => esc_html__('« Prev', 'rmtheme'),
                                'next_text' => esc_html__('Next »', 'rmtheme'),
                                'screen_reader_text' => esc_html__('Posts navigation', 'rmtheme'),
                            )
                    );
                    echo '</div>';
                else :
                    get_template_part('template-parts/template', 'none');
                endif;
                ?>
            </section>

        </div>
    </div>
</main>

<?php
get_footer();
