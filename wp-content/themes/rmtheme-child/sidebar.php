<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rmtheme
 */
?>

<?php if (is_single()) { ?>

    <div class="sidebar-single">

        <div class="sidebar_posts">
            <h2>Recent Posts</h2>
            <div class="sidebar-menu-pa">
                <ul>
                    <?php
                    foreach (wp_get_recent_posts(['numberposts' => 5, 'post_status' => 'publish']) as $post) {
                        echo '<li><a href="' . esc_url(get_permalink($post['ID'])) . '">' . esc_html($post['post_title']) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

        <div class="sidebar_search"><?php get_search_form(); ?></div>

        <div class="sidebar_categories">
            <h2>Categories</h2>
            <ul><?php wp_list_categories(array('orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '',)); ?></ul>
        </div>

        <div class="sidebar_archives">
            <h2>Archives</h2>
            <ul><?php wp_get_archives(array('type' => 'monthly', 'show_post_count' => true,)); ?></ul>
        </div>

        <section class="sidebar_reviews">
            <h2>Latest Reviews</h2>
            <div class="side-reviews">
                <ul>
                    <?php
                    $sidebar_reviews = get_posts([
                        'post_type' => 'review',
                        'posts_per_page' => 10,
                        'orderby' => 'date',
                        'order' => 'DESC',
                    ]);

                    if ($sidebar_reviews) :
                        foreach ($sidebar_reviews as $post) :
                            setup_postdata($post);
                            ?>
                            <li>
                                <div class="review-item">
                                    <div class="star-rat"><!-- Don't Use Empty div's, put something like Rating --></div>
                                    <p><?= wp_trim_words(strip_shortcodes(strip_tags(get_the_content())), 35); ?></p>
                                    <h5><?= esc_html(get_the_title()); ?></h5>
                                </div>
                            </li>
                            <?php
                        endforeach;
                        wp_reset_postdata();
                    endif;
                    ?>
                </ul>
            </div>
        </section>

    </div>

<?php } elseif (is_author() || is_search()) { ?>

    <div class="sidebar-blog">
        <div class="blog_search"><?php get_search_form(); ?></div>
        <div class="blog_archives"><?php the_widget('WP_Widget_Archives', 'dropdown=1'); ?></div></div>
    <div class="blog_categories"><?php the_widget('WP_Widget_Categories', 'dropdown=1&count=1'); ?></div>
    </div>

<?php } ?>
