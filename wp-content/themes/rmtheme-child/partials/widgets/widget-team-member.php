<?php
/**
 * Template part for displaying team member bio information
 *
 * This file is intended to be called from a template using get_template_part().
 */

// Get the main toggle and manually selected bios.
$showBios = get_field('show_bios');
$teamMemberBios = get_field('team_member_bios');

// Define parameters for the fallback function.
$custom_post_type = 'team_member';
$num_post_show = 5;

// A variable to hold the posts we will eventually loop through.
$posts_to_display = [];

// Use the override condition to decide which posts to get.
if ($showBios ) {
    // If the override is active, we get the manually selected bios.
    $posts_to_display = $teamMemberBios;
} else {
    // Otherwise, we get the default bios from the fallback function.
    $fallback_query = getRelatedCPT($custom_post_type, $num_post_show);
    if ($fallback_query && $fallback_query->have_posts()) {
        $posts_to_display = $fallback_query->posts;
    }
}

// Display the team members only if we have posts to show.
if (!empty($posts_to_display)) :
?>
    <section class="widget widget_team_bios">
        <h4 class="widget-title">Attorneys</h4>
        <div class="team-sdbar-list owl-carousel">
        <?php
        // Loop through the posts we've determined to display.
        foreach ($posts_to_display as $post) :
            // Set up post data so WordPress template tags work correctly.
            setup_postdata($post);
        ?>
            <div class="member_bios">
                <div class="bio_pic"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a></div>
                <div class="bio_name"><p><a href="<?php the_permalink(); ?>"><?php the_title(); ?> - <?php echo get_field('team_member_title'); ?></a></p></div>
                <div class="bio_summary"><p><?php the_excerpt(); ?></p></div>
            </div>
        <?php endforeach; ?>
    </div>
    </section>
<?php
    // Always reset post data after a custom loop.
    wp_reset_postdata();
endif;
?>