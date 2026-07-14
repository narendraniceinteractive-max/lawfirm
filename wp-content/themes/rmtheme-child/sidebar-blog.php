<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package rmtheme
 */
?>
<div class="sidebar-blog">
    <div class="sidebar-blog-item blog_search"><?php get_search_form(); ?></div>
    <div class="sidebar-blog-item blog_archives"><?php the_widget('WP_Widget_Archives', 'dropdown=1'); ?></div>
    <div class="sidebar-blog-item blog_categories"><?php the_widget('WP_Widget_Categories', 'dropdown=1&count=1'); ?></div>
</div>