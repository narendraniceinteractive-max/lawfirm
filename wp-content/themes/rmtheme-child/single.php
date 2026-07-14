<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package rmtheme
 */
get_header();
?>
<?php include( get_stylesheet_directory() . '/partials/page-header.php' ); ?>
<main id="page-content">
    <div class="post-container">
        <div class="page-col-full">
            <section id="page-column">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('single-main'); ?>>
                            <?php
                            $fallback_image = get_stylesheet_directory() . '/images/default-post1.webp';
                            $fallback_url = get_stylesheet_directory_uri() . '/images/default-post1.webp';
                            if (has_post_thumbnail()) {
                                $thumb_id = get_post_thumbnail_id(get_the_ID());
                                $thumb_data = wp_get_attachment_image_src($thumb_id, 'sngl_blog_img');
                                $blogUrl = $thumb_data[0];
                                $width = $thumb_data[1];
                                $height = $thumb_data[2];
                            } else {
                                $blogUrl = $fallback_url;
                                if (file_exists($fallback_image)) {
                                    $size = getimagesize($fallback_image);
                                    $width = $size[0];
                                    $height = $size[1];
                                } else {
                                    $width = $height = '';
                                }
                            }
                            ?>
                            <div class="single-thumbnail">
                                <img src="<?php echo esc_url($blogUrl); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="<?php echo esc_attr($width); ?>" height="<?php echo esc_attr($height); ?>" />
                            </div>
                            <div class="single-meta">
                                <div class="single-author">
                                    <?php
                                    $author_id = get_the_author_meta('ID');
                                    $avatar = get_field('author_avatar', 'user_' . $author_id);
                                    if ($avatar):
                                        ?>
                                        <div class="author-avatar">
                                            <a href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" target="_blank">
                                                <img src="<?php echo esc_url($avatar['url']); ?>" alt="<?php echo esc_attr($avatar['alt']); ?>" width="40px" height="40px" style=" border-radius:100%; border: 1px solid black;">
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="author-by">
                                        <p><span>By </span>
                                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                                            <?php printf(__(' %s', 'rmtheme'), get_the_author()); ?>
                                        </a></p>
                                    </div>
                                </div>
                                <div class="single-category">&nbsp; | &nbsp; <p><?php echo get_the_date('M d, Y'); ?></p>&nbsp; | &nbsp;<p><?php the_category(' , '); ?></p></div>
                            </div>
                            <div class="single-content"><?php the_content(); ?></div>
                        </article>
                        <div class="single-post-author">
                            <div class="single-author-box">
                                <?php
                                $author_id = get_the_author_meta('ID');
                                $avatar_img = get_field('author_avatar', 'user_' . $author_id);
                                $avatar_description = get_field('author_description', 'user_' . $author_id);
                                $avatar_link = get_field('author_profile_link', 'user_' . $author_id);
                                ?>
                                <?php if ($avatar_img) { ?>
                                    <div class="single-author-avatar">
                                        <a href="<?php echo esc_url($avatar_link); ?>" target="_blank">
                                            <img src="<?php echo esc_url($avatar_img['url']); ?>" alt="<?php echo esc_attr($avatar_img['alt']); ?>" width="215" height="229" style="border-radius: 100%; border: 1px solid black;">
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="single-author-avatar">
                                        <a href="<?php echo esc_url($avatar_link); ?>" target="_blank">
                                            <img src="<?php echo home_url(); ?>/wp-content/uploads/2025/08/author.webp" alt="<?php echo esc_attr($avatar_img['alt']); ?>" width="215" height="229">

                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="single-author-info">
                                    <h5>Written By <strong><?php echo get_the_author(); ?></strong></h5>
                                    <?php if (!empty($avatar_description)): ?>
                                        <div class="single-author-description">
                                            <?php echo esc_html($avatar_description); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="single-author-ctas">
                                        <?php if ($avatar_link) { ?>
                                            <div class="single-author-link"><a href="<?php echo esc_url($avatar_link); ?>">View Profile</a></div>										
                                        <?php } ?>
                                        <?php if (have_rows('author_social_links', 'user_' . $author_id)): ?>
                                            <div class="single-author-social">
                                                <?php while (have_rows('author_social_links', 'user_' . $author_id)): the_row(); ?>
                                                    <div class="author-social-links">
                                                        <a href="<?php echo esc_url(get_sub_field('author_social_media_link')); ?>" target="_blank" rel="noopener">
                                                            <img src="<?php echo esc_url(get_sub_field('author_social_media_icon')); ?>" alt="<?php echo esc_attr(get_sub_field('author_social_media_name')); ?>" width="45" height="45" />
                                                        </a>
                                                    </div>
                                                <?php endwhile; ?>
                                            </div>
                                        <?php endif; ?>								
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    echo '<div class="single-pagination">';
                    the_post_navigation(
                            array(
                                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous', 'rmtheme') . '</span>',
                                'next_text' => '<span class="nav-subtitle">' . esc_html__('Next', 'rmtheme') . '</span>',
                            )
                    );
                    echo '</div>';
                    ?>
                    <?php
                else :
                    get_template_part('post', 'none');
                endif;
                ?>
            </section>
            
            <?php get_sidebar('single'); ?>
        </div>
    </div>
</main>
<?php
get_footer();
