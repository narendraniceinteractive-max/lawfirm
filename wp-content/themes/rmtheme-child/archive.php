<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rmtheme
 */
get_header();
?>

<section id="main-heading">
    <div class="post-container">

        <?php if (is_author()) : ?>
            <?php
            $author_id = get_queried_object_id();
            $avatar_img = get_field('author_avatar', 'user_' . $author_id);
            $avatar_link = get_field('author_profile_link', 'user_' . $author_id);
            $avatar_description = get_field('author_description', 'user_' . $author_id);
            ?>

            <?php if ($avatar_img): ?>
                <div class="author-title-avatar" style="text-align: center;">
                    <a href="<?php echo esc_url($avatar_link); ?>" target="_blank">
                        <img src="<?php echo esc_url($avatar_img['url']); ?>" alt="<?php echo esc_attr($avatar_img['alt']); ?>" width="150" height="150" style="border-radius: 100%; margin:auto; border: 1px solid black;">
                    </a>
                </div>
            <?php endif; ?>

            <h1><?php the_author(); ?></h1>

        <?php else : ?>

            <h1><?php the_archive_title(); ?></h1>
            <div class="inrpg-breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
                <?php if (function_exists('bcn_display')) bcn_display(); ?>
            </div>

        <?php endif; ?>

    </div>
</section>



<main id="post-content" class="content-area">
    <div class="post-container">




        <div class="post-col-full">

            <?php if (is_author()) : ?>
                <div class="single-author-box" style="margin:25px 0; padding:20px; border:1px solid red;">

                    <?php if ($avatar_description): ?>
                        <div class="author-description">
                            <?php echo esc_html($avatar_description); ?>
                        </div>
                    <?php endif; ?>

                    <div class="author-latest-title">
                        <h5>LATEST ARTICLES BY: <?php printf(__(' %s', 'rmtheme'), get_the_author()); ?></h5>
                    </div>
                </div>






            <?php endif; ?>

            <?php get_sidebar('blog'); ?>

            <section id="post-column-full">

                <div class="post-author-bio">
                    <?php if (is_author()) : ?>
                        <div class="author-bio"><p><?php the_author_meta('description'); ?></p></div>
                        <h5 class="post-author-title"><?php printf(__('LATEST ARTICLES BY: %s', 'rmtheme'), get_the_author()); ?></h5>
                    <?php endif; ?>
                </div>

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
