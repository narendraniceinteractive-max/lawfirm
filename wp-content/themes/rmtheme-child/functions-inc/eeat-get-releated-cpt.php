<?php

/* EEAT - getRelatedCPT function */


/**
 * Function to handle widgets that need to find related content
 */
// used in team-memeber, review, related-post, case-results widgets
function getRelatedCPT($custom_post_type, $num_post_show) {

    // Get the current post's ID
    $current_post_id = get_the_ID();

    // Get the categories and tags from the current post
    $post_categories = get_the_terms( $current_post_id, 'category' );
    $post_tags = get_the_terms( $current_post_id, 'post_tag' );

    // Check if we have any categories or tags to query with
    $category_ids = array();
    if ( $post_categories && !is_wp_error( $post_categories ) ) {
        $category_ids = wp_list_pluck( $post_categories, 'term_id' );
    }

    $tag_ids = array();
    if ( $post_tags && !is_wp_error( $post_tags ) ) {
        $tag_ids = wp_list_pluck( $post_tags, 'term_id' );
    }

    // Initialize related_posts to null. It will hold the successful WP_Query object.
    $related_posts = null;

    // --- Phase 1: Try to match ALL categories AND at least one tag ---
    // This phase only makes sense if the current post actually has both categories AND tags.
    if ( !empty( $category_ids ) && !empty( $tag_ids ) ) {
        $args_phase1 = array(
            'post_type'      => $custom_post_type,
            'post_status'    => 'publish',
            'posts_per_page' => $num_post_show, 
            'post__not_in'   => array( $current_post_id ), // Exclude the current post
            'orderby'        => 'date', // Order by date for consistency
            'order'          => 'DESC', // Newest first
            'tax_query'      => array(
                'relation' => 'AND', // Match ALL of the following conditions
                array( // All categories must be present
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $category_ids,
                    'operator' => 'AND', // This operator ensures ALL given categories are matched
                ),
                array( // At least one tag must be present
                    'taxonomy' => 'post_tag',
                    'field'    => 'term_id',
                    'terms'    => $tag_ids,
                    'operator' => 'IN', // This is default for 'terms', means OR (match any of the given tags)
                ),
            ),
        );
        $related_posts = new WP_Query( $args_phase1 );
    }

    // --- Phase 2: Fallback to match ANY category OR ANY tag ---
    // This runs if Phase 1 didn't yield results AND if we have any categories OR tags to query with.
    if ( (!$related_posts || !$related_posts->have_posts()) && ( !empty( $category_ids ) || !empty( $tag_ids ) ) ) {
        $args_phase2 = array(
            'post_type'      => $custom_post_type,
            'post_status'    => 'publish',
            'posts_per_page' => $num_post_show, // Retrieve all matching posts
            'post__not_in'   => array( $current_post_id ), // Exclude the current post
            'orderby'        => 'date', // Order by date
            'order'          => 'DESC', // Newest first
        );

        $args_phase2['tax_query'] = array(
            'relation' => 'OR', // Match posts that have EITHER a matching category OR a matching tag
        );

        if ( !empty( $category_ids ) ) {
            $args_phase2['tax_query'][] = array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $category_ids,
            );
        }

        if ( !empty( $tag_ids ) ) {
            $args_phase2['tax_query'][] = array(
                'taxonomy' => 'post_tag',
                'field'    => 'term_id',
                'terms'    => $tag_ids,
            );
        }
        $related_posts = new WP_Query( $args_phase2 );
    }

    // --- Phase 3: Ultimate Fallback - All posts of the custom post type, ordered by date ---
    // This runs if neither Phase 1 nor Phase 2 yielded any results.
    if ( ! $related_posts || ! $related_posts->have_posts() ) {
        $args_phase3 = array(
            'post_type'      => $custom_post_type,
            'post_status'    => 'publish',
            'posts_per_page' => $num_post_show, // Retrieve all posts
            'post__not_in'   => array( $current_post_id ), // Exclude the current post
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        $related_posts = new WP_Query( $args_phase3 );
    }

    return $related_posts;
}


