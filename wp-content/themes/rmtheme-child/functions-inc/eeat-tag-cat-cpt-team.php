<?php

/* EEAT - turn on post tags, category and cpt team members */
/* Options: move this into functions.php file and update code there with this */

/**
 * Add existing Categories and Tags to Pages
 */
function add_categories_and_tags_to_pages() {
    // Add existing 'category' taxonomy to 'page' post type
    register_taxonomy_for_object_type( 'category', 'page' );

    // Add existing 'post_tag' taxonomy to 'page' post type
    register_taxonomy_for_object_type( 'post_tag', 'page' );

    //check if case_result CPT exist
    if ( post_type_exists( 'case_result' ) ) {
        register_taxonomy_for_object_type( 'category', 'case_result' );
        register_taxonomy_for_object_type( 'post_tag', 'case_result' );
    }
    //check if review CPT exist
    if ( post_type_exists( 'review' ) ) {
        register_taxonomy_for_object_type( 'category', 'review' );
        register_taxonomy_for_object_type( 'post_tag', 'review' );
    }

}
add_action( 'init', 'add_categories_and_tags_to_pages' );

/**
 * CPT Team Members Setup
 */
//feel free to change the slug or anything else with this -  do not change name of cpt since that will be used
//use the archive of this cpt for the team pages - should be able to loop through the cpt to display them 
//need to pull in headshot (feature image), name (page title), title (acf field), short summary (excerpt), and link (url) for team memeber widget
//need to pull in name (page title), title (Optional to include)(acf field), and link (url) use this cpt in the fact checked cpt team widget 
function create_team_member_post_type() {
    $labels = array(
        'name'          => 'Team Members',
        'singular_name' => 'Team Member',
        'add_new'       => 'Add New',
        'add_new_item'  => 'Add New Team Member',
        'edit_item'     => 'Edit Team Member',
        'new_item'      => 'New Team Member',
        'view_item'     => 'View Team Member',
    );

    $args = array(
        'labels'               => $labels,
        'public'               => true,
        'publicly_queryable'   => true,
        'show_ui'              => true,
        'show_in_menu'         => true,
        'query_var'            => true,
        'rewrite'              => array( 'slug' => 'team-members', 'with_front' => false ),
        'capability_type'      => 'post',
        'has_archive'          => true,
        'hierarchical'         => true, // Changed: Set to true to allow parent-child relationships.
        'menu_position'        => 5,
        'supports'             => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ), // Changed: Added 'page-attributes'.
        'show_in_rest'         => true,
        'menu_icon'            => 'dashicons-id',
        'taxonomies'           => array( 'category', 'post_tag' ),
    );

    register_post_type( 'team_member', $args );
}
add_action( 'init', 'create_team_member_post_type' );


