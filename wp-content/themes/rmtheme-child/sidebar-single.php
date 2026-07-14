<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rmtheme
 */
?>
<div class="sidebar-page sidebar-single">
    <div class="sidebar-item sidebar_posts">
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

<div class="sidebar-blog blog-sidebar-itm">
    <div class="sidebar-item sidebar_search"><?php get_search_form(); ?></div>
    <div class="sidebar-item sidebar_categories">
        <h2>Categories</h2>
        <ul><?php the_widget('WP_Widget_Categories', 'dropdown=1&count=1'); ?></ul>
    </div>
    <div class="sidebar-item sidebar_archives">
        <h2>Archives</h2>
        <ul><?php the_widget('WP_Widget_Archives', 'dropdown=1'); ?></ul>
    </div>
</div>
</div>
