<?php
/**
 * Template part for displaying related posts 
 *
 * This file is intended to be called from a template using get_template_part().
 */

// Set the name of your custom post type here
$custom_post_type = 'post';

$num_post_show = 3;

$related_posts = getRelatedCPT($custom_post_type, $num_post_show);

// The Loop - modify the html, acf fields, or whatever is needed to fit the design
if ( $related_posts->have_posts() ) :?>

    <section class="widget widget_recent_entries">
		<h4 class="widget-title">Related Insights</h4>
        <nav aria-label="Recent Posts">
		<ul>
             <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
				<li>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</li>
             <?php endwhile; ?>                       
		
		</ul>

		</nav>
    </section>

	
<?php
endif;

// Reset the post data to restore the main query
wp_reset_postdata();